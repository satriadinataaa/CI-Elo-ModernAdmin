<?php 
class PelangganCest
{
    private $faker;
    private $idPelanggan = [];

    public function _before(AcceptanceTester $I)
    {
        $this->faker = Faker\Factory::create();
    }

    public function beforeAllTest(AcceptanceTester $I)
    {
    	$I->amOnPage('/login');
        $I->see('Sistem Manajemen Pemeliharaan AMR dan APP');
        $I->fillField('username', 'azhry');
        $I->fillField('password', '4kuGanteng');
        $I->click('login');
        $I->see('Dashboard');

        $I->click(['id' => 'menu-pelanggan']);
        $I->see('Data Pelanggan');

        $I->click(['id' => 'tambah-pelanggan']);
        $I->see('Tambah Pelanggan');
    }

    // real tests here
    public function tambahPelanggan(AcceptanceTester $I)
    {
        $this->idPelanggan []= '021181419007';

        // data pelanggan
    	$I->fillField('id_pelanggan', '021181419007');
        $I->fillField('nama', 'Azhary Arliansyah');
        $I->fillField('alamat', 'Jl. Waringin Lintas No. 25');
        $I->selectOption('id_tarif', 2);
        $I->selectOption('id_daya', 2);
        $I->selectOption('id_kode_unit', 3);
        
        $I->click(['id' => 'continue-btn']);

        // data APP
        $I->fillField('no_meter', '021181419007');
    	$I->selectOption('id_merk_meter', 2);
        $I->fillField('tahun_buat', '2018');
        $I->selectOption('id_type_meter', 2);
        $I->selectOption('id_spesifikasi_meter', 2);
        $I->selectOption('id_faktor_kali', 2);
        $I->selectOption('id_ct', 2);
        $I->selectOption('id_pt', 2);
        $I->selectOption('id_merk_pembatas', 2);
        $I->selectOption('id_type_pembatas', 2);
        $I->selectOption('id_rating_pembatas', 2);
        $I->selectOption('id_type_box', 2);
        $I->fillField('keterangan', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum');
    
        $I->click(['id' => 'continue-btn']);

        // data modem
        $I->fillField('imei', '009021181419007');
        $I->selectOption('id_merk_modem', 2);
        $I->selectOption('id_type_modem', 2);

        $I->click(['id' => 'continue-btn']);

        // data sim card
        $I->fillField('no_sim_card', '021181419007');
        $I->selectOption('id_provider', 2);
        $I->fillField('ip_address', '10.10.10.10');

        $I->click('submit');
        $I->see('Data pelanggan berhasil disimpan');
    }

    public function editPelanggan(AcceptanceTester $I)
    {
        $I->click(['id' => 'edit-021181419007']);
        $I->see('Edit Pelanggan');

        $idPelanggan = $this->faker->numerify('############');
        $this->idPelanggan []= $idPelanggan;

        // data pelanggan
        // $I->fillField('id_pelanggan', $idPelanggan);
        $I->fillField('nama', $this->faker->name);
        $I->fillField('alamat', $this->faker->address);
        $I->selectOption('id_tarif', $this->faker->numberBetween(1, 24));
        $I->selectOption('id_daya', $this->faker->numberBetween(1, 33));
        $I->selectOption('id_kode_unit', $this->faker->numberBetween(1, 10));
        
        $I->click(['id' => 'continue-btn']);

        // data APP
        $I->fillField('no_meter', $this->faker->numerify('############'));
        $I->selectOption('id_merk_meter', $this->faker->numberBetween(1, 4));
        $I->fillField('tahun_buat', $this->faker->numberBetween(2000, 2019));
        $I->selectOption('id_type_meter', $this->faker->numberBetween(1, 6));
        $I->selectOption('id_spesifikasi_meter', $this->faker->numberBetween(1, 4));
        $I->selectOption('id_faktor_kali', $this->faker->numberBetween(1, 23));
        $I->selectOption('id_ct', $this->faker->numberBetween(1, 22));
        $I->selectOption('id_pt', $this->faker->numberBetween(1, 2));
        $I->selectOption('id_merk_pembatas', $this->faker->numberBetween(1, 4));
        $I->selectOption('id_type_pembatas', $this->faker->numberBetween(1, 4));
        $I->selectOption('id_rating_pembatas', $this->faker->numberBetween(1, 34));
        $I->selectOption('id_type_box', $this->faker->numberBetween(1, 3));
        $I->fillField('keterangan', $this->faker->text);
    
        $I->click(['id' => 'continue-btn']);

        // data modem
        $I->fillField('imei', $this->faker->numerify('###############'));
        $I->selectOption('id_merk_modem', $this->faker->numberBetween(1, 4));
        $I->selectOption('id_type_modem', $this->faker->numberBetween(1, 8));

        $I->click(['id' => 'continue-btn']);

        // data sim card
        $I->fillField('no_sim_card', $this->faker->numerify('############'));
        $I->selectOption('id_provider', $this->faker->numberBetween(1, 2));

        $randIP = "".mt_rand(0,255).".".mt_rand(0,255).".".mt_rand(0,255).".".mt_rand(0,255);
        $I->fillField('ip_address', $randIP);

        $I->click('submit');
        $I->makeScreenshot();
        $I->see('Data pelanggan berhasil disimpan');

        $I->click(['id' => 'menu-data-pelanggan']);
        
    }

    public function tambahFakePelanggan(AcceptanceTester $I)
    {
        for ($i = 0; $i < 2; $i++)
        {
            $I->click(['id' => 'tambah-pelanggan']);
            $I->see('Tambah Pelanggan');

            $idPelanggan = $this->faker->numerify('############');
            $this->idPelanggan []= $idPelanggan;

            // data pelanggan
            $I->fillField('id_pelanggan', $idPelanggan);
            $I->fillField('nama', $this->faker->name);
            $I->fillField('alamat', $this->faker->address);
            $I->selectOption('id_tarif', $this->faker->numberBetween(1, 24));
            $I->selectOption('id_daya', $this->faker->numberBetween(1, 33));
            $I->selectOption('id_kode_unit', $this->faker->numberBetween(1, 10));
            
            $I->click(['id' => 'continue-btn']);

            // data APP
            $I->fillField('no_meter', $this->faker->numerify('############'));
            $I->selectOption('id_merk_meter', $this->faker->numberBetween(1, 4));
            $I->fillField('tahun_buat', $this->faker->numberBetween(2000, 2019));
            $I->selectOption('id_type_meter', $this->faker->numberBetween(1, 6));
            $I->selectOption('id_spesifikasi_meter', $this->faker->numberBetween(1, 4));
            $I->selectOption('id_faktor_kali', $this->faker->numberBetween(1, 23));
            $I->selectOption('id_ct', $this->faker->numberBetween(1, 22));
            $I->selectOption('id_pt', $this->faker->numberBetween(1, 2));
            $I->selectOption('id_merk_pembatas', $this->faker->numberBetween(1, 4));
            $I->selectOption('id_type_pembatas', $this->faker->numberBetween(1, 4));
            $I->selectOption('id_rating_pembatas', $this->faker->numberBetween(1, 34));
            $I->selectOption('id_type_box', $this->faker->numberBetween(1, 3));
            $I->fillField('keterangan', $this->faker->text);
        
            $I->click(['id' => 'continue-btn']);

            // data modem
            $I->fillField('imei', $this->faker->numerify('###############'));
            $I->selectOption('id_merk_modem', $this->faker->numberBetween(1, 4));
            $I->selectOption('id_type_modem', $this->faker->numberBetween(1, 8));

            $I->click(['id' => 'continue-btn']);

            // data sim card
            $I->fillField('no_sim_card', $this->faker->numerify('############'));
            $I->selectOption('id_provider', $this->faker->numberBetween(1, 2));

            $randIP = "".mt_rand(0,255).".".mt_rand(0,255).".".mt_rand(0,255).".".mt_rand(0,255);
            $I->fillField('ip_address', $randIP);

            $I->click('submit');
            $I->see('Data pelanggan berhasil disimpan');
        }
        
    }

    public function loginAsTransaksiEnergi(AcceptanceTester $I)
    {
        $I->amOnPage('/login');
        $I->see('Sistem Manajemen Pemeliharaan AMR dan APP');
        $I->fillField('username', 'az');
        $I->fillField('password', '4kuGanteng');
        $I->click('login');
        $I->see('Dashboard');
    }

    public function goToValidasiTargetOperasional(AcceptanceTester $I)
    {
        $I->click(['id' => 'menu-validasi-amr']);
        $I->click(['id' => 'menu-target-operasi-validasi']);
        $I->see('Target Operasi Validasi AMR');
        $I->click(['id' => 'tambah-target-operasi-validasi']);
        $I->see('Tambah Target Operasi Validasi AMR');
    }

    public function inputValidasiTargetOperasional(AcceptanceTester $I)
    {
        $I->fillField('id_pelanggan', $this->faker->randomElement($this->idPelanggan));
        $I->fillField('alasan', $this->faker->text);
        $I->fillField('keterangan', $this->faker->text);
        $I->click('submit');
        $I->makeScreenshot();
    }

    public function goToTargetOperasional(AcceptanceTester $I)
    {
        $I->click(['id' => 'menu-pemeliharaan-amr']);
        $I->click(['id' => 'menu-target-operasi']);
        $I->see('Target Operasi SOP AMR');
        $I->click(['id' => 'tambah-target-operasi']);
        $I->see('Tambah Target Operasi SOP AMR');
    }

    public function inputTargetOperasional(AcceptanceTester $I)
    {
        $I->fillField('id_pelanggan', $this->faker->randomElement($this->idPelanggan));
        $I->fillField('alasan', $this->faker->text);
        $I->fillField('keterangan', $this->faker->text);
        $I->click('submit');
        $I->makeScreenshot();
    }
}
