<?= $this->include('share_pages/header') ?>

<body>
    <div id="app">
        <!-- menu sidebar -->
        <?= $this->include('share_pages/sidebar') ?>
        <div id="main" class='layout-navbar'>
            <header class='mb-3'>
                <!-- menu sidebar -->
                <?= $this->include('share_pages/navbar') ?>
            </header>
            <div id="main-content">
                <div class="page-heading">
                    <!-- heading halaman -->
                    <?= $this->include('share_pages/heading') ?>

                    <!-- awal halaman content -->
                    <?= $this->renderSection('content') ?>
                    <!-- akhir halaman content -->
                </div>

                <!-- footer -->
                <?= $this->include('share_pages/footer') ?>
            </div>
        </div>
    </div>
    <script src="/assets/js/bootstrap.js"></script>
    <script src="/assets/js/app.js"></script>

    <script src="https://cdn.datatables.net/v/bs5/dt-1.12.1/datatables.min.js"></script>
    <script src="/assets/js/pages/datatables.js"></script>

</body>

</html>