<aside class="main-sidebar">
    <!-- sidebar-->
    <section class="sidebar position-relative">
        <div class="multinav">
            <div class="multinav-scroll" style="height: 100%;">
                <!-- sidebar menu-->
                <ul class="sidebar-menu" data-widget="tree">
                    <li class="header">Menu</li>
                    <li class="treeview">
                        <a href="#">
                            <i class="icon-Layout-4-blocks"><span class="path1"></span><span class="path2"></span></i>
                            <span>Point of Sale</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-right pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="<?= base_url('/dashboard') ?>"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Dashboard</a></li>
                            <li><a href="<?= base_url('/transaksi') ?>"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Transaksi</a></li>
                        </ul>
                    </li>
                    <li class="treeview">
                        <a href="#">
                            <i class="icon-Layout-4-blocks"><span class="path1"></span><span class="path2"></span></i>
                            <span>Master Data</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-right pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="<?= base_url('/jenis-barang') ?>"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Jenis Barang</a></li>
                            <li><a href="<?= base_url('/barang') ?>"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Barang</a></li>
                            <li><a href="<?= base_url('/stock-history') ?>"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Stock Adjustment</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </section>
</aside>