<?php $session = \Config\Services::session() ?>
<?php $this->extend('share_pages/layout') ?>
<?php $this->section('content') ?>

<section class="section">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <h4 class="mr-3"><?= $title ?></h4>
            </div>
            <div class="text-muted">
                <span id="currentDate">
                    <?php
                    setlocale(LC_TIME, 'id_ID.UTF-8');
                    echo strftime('%A, %d %B %Y'); // Format tanggal dalam bahasa Indonesia
                    ?>
                </span> - 
                <span id="currentTime"><?= date('H:i:s') ?></span>
            </div>
        </div>
        <div class="card-body">
            <div class="button-group mb-4">
                <button class="btn btn-primary" onclick="startScanner()">Mulai Pemindaian</button>
                <button class="btn btn-danger" onclick="stopScanner()">Berhenti Pemindaian</button>
            </div>
            <div id="reader" class="mb-4"></div>
            <div id="result" class="mt-3"></div>
        </div>
    </div>
</section>
<div class="fshow-qrsiswa"></div>

<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<!-- Include Html5Qrcode library -->
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"> </script>

<script>
    // Function to update the time every second
    function updateTime() {
        var now = new Date();
        var hours = String(now.getHours()).padStart(2, '0');
        var minutes = String(now.getMinutes()).padStart(2, '0');
        var seconds = String(now.getSeconds()).padStart(2, '0');

        document.getElementById('currentTime').textContent = hours + ':' + minutes + ':' + seconds;
    }

    // Update time every second
    setInterval(updateTime, 1000);

    let html5QrcodeScanner = new Html5QrcodeScanner(
         "reader",
        { fps: 10, qrbox: { width: 600, height: 600 } },
        false
    );

    function onScanSuccess(qrMessage) {
        // handle the scanned code as you like
        console.log(`QR matched = ${qrMessage}`);
        // Stop scanning
        html5QrcodeScanner.clear().then(_ => {
            $.ajax({
                url: "scanQrAbsensi",
                data: {
                    nis: qrMessage,
                    guruId: <?= $session->id ?>
                },
                type: "get",
                dataType: "json",
                success: function(responds) {
                    $('.fshow-qrsiswa').html(responds);
                    $("#showQrCodeModal").modal("toggle");
                },
                error: function(request, status, error) {
                    console.log(request.responseText);
                    console.log(qrMessage);
                    alert(request.responseText);
                }
            });     
        }).catch(error => {
            // Could not stop scanning for reasons specified in `error`.
            // This conditions should ideally not happen.
        });
    }

    function onScanFailure(error) {
        // handle scan failure, usually better to ignore and keep scanning
        console.warn(`QR error = ${error}`);
    }

    const startScanner = () => html5QrcodeScanner.render(onScanSuccess, onScanFailure);
    
    const stopScanner = () => html5QrcodeScanner.clear();

</script>

<?php $this->endSection() ?>
