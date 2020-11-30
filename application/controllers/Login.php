<?php  

class Login extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->data['id_role']	= $this->session->userdata('id_role');
		if (isset($this->data['id_role']))
		{
			switch ($this->data['id_role'])
			{
				case 1:
					redirect('Owner');
					break;

				case 2:
					redirect('Employee');
					break;
			}
		}
	}

	public function index()
	{
		if ($this->POST('submit'))
		{
			$this->load->model('M_Users');

			$account = M_Users::where('username', $this->POST('username'))
						->where('password', md5($this->POST('password')))
						->first();

			if (isset($account))
			{
				$this->flashmsg('Login Sukses');
				$this->session->set_userdata([
					'account_id'	=> $account->id_user,
					'id_role'		=> $account->id_role,
					'username'		=> $account->username,
					'name'			=> $account->nama,
					'cabang'		=> $account->id_cabang
				]);

				redirect('login');
			}
			else
			{
				$this->flashmsg('Wrong username or password', 'danger');
				$this->go_back(-1);
			}

			exit;
		}
		
        $this->load->view('login');
	}
}