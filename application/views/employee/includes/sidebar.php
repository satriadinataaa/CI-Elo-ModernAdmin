
    <div id="wrapper">

    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav metismenu" id="side-menu">
                <li class="nav-header">
                    <div class="dropdown profile-element"> 
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold"><?= $branchName ?></strong>
                             </span> 
                    </div>
                    <div class="logo-element">
                        AMF      
                  </div>
                </li>
                <li>
                    <a href="<?php echo base_url(); ?>Employee/createMedicine"><i class="fa fa-plus-circle"></i> <span class="nav-label">Tambah Obat</span></a>
                </li>
                <li>
                    <a href="<?php echo base_url(); ?>Employee/updateStock"><i class="fa fa-edit"></i> <span class="nav-label">Update Stok</span></a>
                </li>
                <li>
                    <a href="<?php echo base_url(); ?>Employee/"><i class="fa fa-shopping-cart"></i> <span class="nav-label">Kasir</span></a>
                </li>
                <li>
                    <a href="<?php echo base_url(); ?>Employee/checkMedicine"><i class="fa fa-search"></i> <span class="nav-label">Check Obat</span></a>
                </li>
               <li>
                    <a href="<?php echo base_url(); ?>Employee/expiredMedicine"><i class="fa fa-times"></i> <span class="nav-label">Obat Expired</span></a>
                </li>
                <li>
                    <a href="<?php echo base_url(); ?>Employee/kasBon"><i class="fa fa-dollar"></i> <span class="nav-label">Bon</span></a>
                </li>
                <li>
                    <a href="<?php echo base_url(); ?>Employee/transaksiOnline"><i class="fa fa-globe"></i> <span class="nav-label">Transaksi Online</span></a>
                </li>
            </ul>

        </div>
    </nav>