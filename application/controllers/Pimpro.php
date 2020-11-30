<?php  

class Pimpro extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->data['role_id']	= $this->session->userdata('role_id');
		if (!isset($this->data['role_id']) or $this->data['role_id'] != SERVICE_PROVIDER)
		{
			$this->session->sess_destroy();
			redirect('login');
		}

		$this->module = 'pimpro';
		
		$this->data['name'] 	= $this->session->userdata('name');
		$this->data['account_id'] = $this->session->userdata('account_id');
	}

	public function index()
	{
		$this->load->model('M_Projects');

		$this->data['projects']	= M_Projects::where('provider_id', $this->data['account_id'])
									->with(['provider', 'type'])
									->orderBy('id', 'DESC')
									->get();
		$this->data['title'] 	= 'home';
    	$this->data['content'] 	= 'Home';
        $this->template($this->data, $this->module);
	}

	public function input_realisasi()
	{
		$this->data['project_id'] = $this->uri->segment(3);
		$this->check_allowance(!isset($this->data['project_id']));

		$this->load->model('M_Projects');
		$this->data['project'] = M_Projects::with('items')->find($this->data['project_id']);
		$this->check_allowance(!isset($this->data['project']), ['Data not found', 'danger']);

		$financialItems = M_ProjectItem::where('project_id', $this->data['project_id'])->where('item_type', 'Financial')->get();
		$physicalItems = M_ProjectItem::where('project_id', $this->data['project_id'])->where('item_type', 'Physical')->get();

		if ($this->POST('submit'))
		{
			M_Projects::getConnectionResolver()->connection()->beginTransaction();

			try
			{
				$this->load->model('M_FinancialHistories');
				foreach ($financialItems as $financialItem)
				{
					$financialHistory 				= new M_FinancialHistories();
					$financialHistory->item_id 		= $financialItem->id;
					$financialHistory->history_date	= $this->POST('history_date');
					$financialHistory->realization	= $this->POST('financial_realization_' . $financialItem->id);
					$financialHistory->target 		= $this->POST('financial_target_' . $financialItem->id);
					$financialHistory->save();
				}
				

				$this->load->model('M_PhysicalHistories');
				foreach ($physicalItems as $physicalItem)
				{
					$financialHistory 				= new M_FinancialHistories();
					$financialHistory->item_id 		= $physicalItem->id;
					$financialHistory->history_date	= $this->POST('history_date');
					$financialHistory->realization	= $this->POST('financial_realization_' . $physicalItem->id);
					$financialHistory->target 		= $this->POST('financial_target_' . $physicalItem->id);
					$financialHistory->save();
					
					$physicalHistory 				= new M_PhysicalHistories();
					$physicalHistory->item_id 		= $physicalItem->id;
					$physicalHistory->history_date	= $this->POST('history_date');
					$physicalHistory->planning		= $this->POST('physical_planning_' . $physicalItem->id);
					$physicalHistory->realization	= $this->POST('physical_realization_' . $physicalItem->id);
					$physicalHistory->target 		= $this->POST('physical_target_' . $physicalItem->id);
					$physicalHistory->save();
				}

				M_Projects::getConnectionResolver()->connection()->commit();
				$this->flashmsg('Create new realization success');
				redirect('pimpro/input-realisasi/' . $this->data['project_id']);
			}
			catch (Exception $e)
			{
				M_Projects::getConnectionResolver()->connection()->rollback();
				$this->flashmsg($e->getMessage(), 'danger');
				$this->go_back(-1);
			}
			
			exit;
		}

		$this->data['financial_items'] 	= $financialItems;
		$this->data['physical_items']	= $physicalItems;
		$this->data['title'] 			= 'Input Realisasi';
    	$this->data['content'] 			= 'input_realisasi';
        $this->template($this->data, $this->module);
	}

	public function edit_realisasi()
	{
		$this->data['project_id'] 	= $this->GET('project_id');
		$this->check_allowance(!isset($this->data['project_id']));

		$this->data['month']		= $this->GET('month');
		$this->check_allowance(!isset($this->data['month']));

		$this->data['year']			= $this->GET('year');
		$this->check_allowance(!isset($this->data['year']));

		$this->load->model('M_Projects');
		$this->data['project'] = M_Projects::with('items')->find($this->data['project_id']);
		$this->check_allowance(!isset($this->data['project']), ['Data not found', 'danger']);

		$financialItems = M_ProjectItem::with(['financial_histories' => function($query) {
			$query->whereMonth('history_date', '=', $this->data['month']);
			$query->whereYear('history_date', '=', $this->data['year']);
		}])
							->where('project_id', $this->data['project_id'])
							->where('item_type', 'Financial')
							->get();
		$physicalItems = M_ProjectItem::with(['physical_histories' => function($query) {
			$query->whereMonth('history_date', '=', $this->data['month']);
			$query->whereYear('history_date', '=', $this->data['year']);
		}, 'financial_histories' => function($query) {
			$query->whereMonth('history_date', '=', $this->data['month']);
			$query->whereYear('history_date', '=', $this->data['year']);
		}])
							->where('project_id', $this->data['project_id'])
							->where('item_type', 'Physical')
							->get();

		if ($this->POST('submit'))
		{
			M_Projects::getConnectionResolver()->connection()->beginTransaction();

			try
			{
				foreach ($financialItems as $financialItem)
				{
					$financialHistoriesId 	= $this->POST('financial_histories_id_' . $financialItem->id);
					foreach ($financialHistoriesId as $id)
					{
						$financialHistory 				= M_FinancialHistories::find($id);
						if (isset($financialHistory))
						{
							$financialHistory->realization	= $this->POST('financial_realization_' . $financialItem->id . '_' . $id);
							$financialHistory->target 		= $this->POST('financial_target_' . $financialItem->id . '_' . $id);
							$financialHistory->save();
						}
						
					}
					
				}

				foreach ($physicalItems as $physicalItem)
				{
					$financialHistoriesId 	= $this->POST('financial_histories_id_' . $physicalItem->id);
					foreach ($financialHistoriesId as $id)
					{
						$financialHistory 				= M_FinancialHistories::find($id);
						if (isset($financialHistory))
						{
							$financialHistory->realization	= $this->POST('financial_realization_' . $physicalItem->id . '_' . $id);
							$financialHistory->target 		= $this->POST('financial_target_' . $physicalItem->id . '_' . $id);
							$financialHistory->save();	
						}
						
					}

					$physicalHistoriesId 	= $this->POST('physical_histories_id_' . $physicalItem->id);
					foreach ($physicalHistoriesId as $id)
					{
						$physicalHistory 				= M_PhysicalHistories::find($id);
						if (isset($physicalHistory))
						{
							$physicalHistory->planning		= $this->POST('physical_planning_' . $physicalItem->id . '_' . $id);
							$physicalHistory->realization	= $this->POST('physical_realization_' . $physicalItem->id . '_' . $id);
							$physicalHistory->target 		= $this->POST('physical_target_' . $physicalItem->id . '_' . $id);
							$physicalHistory->save();
						}
					}
					
				}

				M_Projects::getConnectionResolver()->connection()->commit();
				$this->flashmsg('Edit realization success');
				redirect('pimpro/edit-realisasi?project_id=' . $this->data['project_id'] . '&month=' . $this->data['month'] . '&year=' . $this->data['year']);
			}
			catch (Exception $e)
			{
				M_Projects::getConnectionResolver()->connection()->rollback();
				$this->flashmsg($e->getMessage(), 'danger');
				$this->go_back(-1);
			}
			
			exit;
		}

		$this->data['financial_items'] 	= $financialItems;
		$this->data['physical_items']	= $physicalItems;

		// $this->dump($this->data['financial_items']->toArray());
		// $this->dump($this->data['physical_items']->toArray());
		// exit;

		$this->data['title'] 			= 'Edit Realisasi';
    	$this->data['content'] 			= 'edit_realisasi';
        $this->template($this->data, $this->module);
	}

	public function history()
	{
		if ($this->POST('month') && $this->POST('year'))
		{
			$this->data['month']	= $this->POST('month');
			$this->data['year']		= $this->POST('year');
		}
		else
		{
			$this->data['month']	= date('m');
			$this->data['year']		= date('Y');
		}
		
		
		$this->load->model('M_Projects');
		$this->data['projects'] = M_Projects::with(['items', 'provider', 'type', 'items.physical_histories' => function($query) {
			$query->whereMonth('history_date', '=', $this->data['month']);
			$query->whereYear('history_date', '=', $this->data['year']);
		}, 'items.financial_histories' => function($query) {
			$query->whereMonth('history_date', '=', $this->data['month']);
			$query->whereYear('history_date', '=', $this->data['year']);
		}])->get();

		// $this->dump($this->data['projects']->toArray());
		// exit;

		$this->data['title'] 	= 'History';
		$this->data['content'] 	= 'history';
		$this->template($this->data, $this->module);
	}

	public function report()
	{
		$this->data['project_id'] = $this->uri->segment(3);
		$this->check_allowance(!isset($this->data['project_id']));

		$this->load->model('M_Projects');
		$this->data['project'] = M_Projects::with('items')->find($this->data['project_id']);
		$this->check_allowance(!isset($this->data['project']), ['Data not found', 'danger']);

		if ($this->POST('month') && $this->POST('year'))
		{
			$this->data['month'] 	= $this->POST('month');
			$this->data['year']		= $this->POST('year');
		}
		else
		{
			$this->data['month']	= date('m');
			$this->data['year']		= date('Y');
		}

		$this->data['project_items'] = M_ProjectItem::with(['physical_histories' => function($query) {
				$query->whereMonth('history_date', '=', $this->data['month']);
				$query->whereYear('history_date', '=', $this->data['year']);
			}, 'financial_histories' => function($query) {
				$query->whereMonth('history_date', '=', $this->data['month']);
				$query->whereYear('history_date', '=', $this->data['year']);
			}])
										->where('project_id', $this->data['project_id'])
										->get();

		// $this->dump($this->data['project_items']->toArray());
		// exit;

		$this->data['title'] 	= 'Laporan';
		$this->data['content'] 	= 'report';
		$this->template($this->data, $this->module);
	}

	public function edit_project()
	{
		$this->data['project_id'] = $this->uri->segment(3);
		$this->check_allowance(!isset($this->data['project_id']));

		$this->load->model('M_Projects');
		$this->data['project'] = M_Projects::with('items')->find($this->data['project_id']);
		$this->check_allowance(!isset($this->data['project']), ['Data not found', 'danger']);

		$this->load->model('M_ProjectType');
		$this->load->model('M_Accounts');

		if ($this->POST('submit'))
		{
			M_Projects::getConnectionResolver()->connection()->beginTransaction();

			try
			{
				$project 					= M_Projects::find($this->data['project_id']);
				$project->type_id 			= $this->POST('type_id');
				$project->provider_id		= $this->POST('provider_id');
				$project->project_name		= $this->POST('project_name');
				$project->contract_number	= $this->POST('contract_number');
				$project->contract_date		= $this->POST('contract_date');
				$project->contract_value	= $this->POST('contract_value');
				$project->supervisor		= '';
				$project->save();

				$financialItem 					= M_ProjectItem::find($this->POST('financial_item_id'));
				$financialItem->project_id 		= $project->id;
				$financialItem->name 			= 'Administrasi Keuangan';
				$financialItem->budget_ceiling	= $this->POST('financial_budget_ceiling');
				$financialItem->item_type 		= 'Financial';
				$financialItem->save();

				$oldPhysicalItemsId = $this->POST('old_physical_items_id');
				$deletedOldItemsId 	= $this->POST('deleted_old_items_id');
				$itemNames 			= $this->POST('item_name');
				$itemBudgetCeilings = $this->POST('item_budget_ceiling');

				foreach ($deletedOldItemsId as $id)
				{
					M_ProjectItem::where('id', $id)->delete();
				}

				for ($i = 0; $i < count($oldPhysicalItemsId); $i++)
				{
					$physicalItem 					= M_ProjectItem::find($oldPhysicalItemsId[$i]);
					$physicalItem->project_id 		= $project->id;
					$physicalItem->name 			= $itemNames[$i];
					$physicalItem->budget_ceiling	= $itemBudgetCeilings[$i];
					$physicalItem->item_type 		= 'Physical';
					$physicalItem->save();
				}

				for (; $i < count($itemNames); $i++)
				{
					$physicalItem 					= new M_ProjectItem();
					$physicalItem->project_id 		= $project->id;
					$physicalItem->name 			= $itemNames[$i];
					$physicalItem->budget_ceiling	= $itemBudgetCeilings[$i];
					$physicalItem->item_type 		= 'Physical';
					$physicalItem->save();
				}

				M_Projects::getConnectionResolver()->connection()->commit();
				$this->flashmsg('Edit program success');
				redirect('pimpro/edit-project/' . $this->data['project_id']);
			}
			catch (Exception $e)
			{
				M_Projects::getConnectionResolver()->connection()->rollback();
				$this->flashmsg($e->getMessage(), 'danger');
				$this->go_back(-1);
			}
		}

		if ($this->POST('add_project_type'))
		{
			$projectType = new M_ProjectType();
			$projectType->type = $this->POST('type');
			$projectType->description = $this->POST('description');

			if ($projectType->save())
			{
				$this->data['types'] = M_ProjectType::orderBy('id', 'DESC')->get();
				echo json_encode([
					'status'	=> 'success',
					'data'		=> $this->data['types']->toArray()
				]);
			}
			else
			{
				echo json_encode([
					'status'	=> 'failed',
					'message'	=> 'Unable to add new project type'
				]);
			}

			
			exit;
		}

		if ($this->POST('add_service_provider'))
		{
			$password 	= $this->POST('password');
			$rpassword 	= $this->POST('rpassword');
			if ($password !== $rpassword)
			{
				echo json_encode([
					'status'	=> 'failed',
					'message'	=> 'Password must be equals to confirm password'
				]);
				exit;
			}

			$username = $this->POST('username');
			$checkServiceProvider = M_Accounts::where('username', $username)->first();
			if (isset($checkServiceProvider))
			{
				echo json_encode([
					'status'	=> 'failed',
					'message'	=> 'The username is already used'
				]);
				exit;	
			}

			$email = $this->POST('email');
			$checkServiceProvider = M_Accounts::where('email', $email)->first();
			if (isset($checkServiceProvider))
			{
				echo json_encode([
					'status'	=> 'failed',
					'message'	=> 'The email is already used'
				]);
				exit;	
			}

			$serviceProvider 			= new M_Accounts();
			$serviceProvider->username 	= $username;
			$serviceProvider->password 	= md5($this->POST('password'));
			$serviceProvider->role_id 	= SERVICE_PROVIDER;
			$serviceProvider->name 		= $this->POST('name');
			$serviceProvider->contact 	= $this->POST('contact');
			$serviceProvider->email 	= $email;
			if ($serviceProvider->save())
			{
				$this->data['vendors'] = M_Accounts::where('role_id', SERVICE_PROVIDER)
										->orderBy('id', 'DESC')
										->get();
				echo json_encode([
					'status'	=> 'success',
					'data'		=> $this->data['vendors']->toArray()
				]);
			}
			else
			{
				echo json_encode([
					'status'	=> 'failed',
					'message'	=> 'Unable to add new service provider'
				]);
			}

			
			exit;	
		}

		$this->data['financial_items'] = M_ProjectItem::where('project_id', $this->data['project_id'])
											->where('item_type', 'Financial')
											->get();
		$this->data['physical_items'] = M_ProjectItem::where('project_id', $this->data['project_id'])
											->where('item_type', 'Physical')
											->get();
											

		$this->data['types']	= M_ProjectType::orderBy('id', 'DESC')->get();
		$this->data['vendors']	= M_Accounts::where('role_id', SERVICE_PROVIDER)
									->orderBy('id', 'DESC')
									->get();
		$this->data['title'] 	= 'Edit Proyek';
    	$this->data['content'] 	= 'editproject';
        $this->template($this->data, $this->module);
	}
	
}