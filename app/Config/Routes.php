<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/tes', 'Tes::index');
$routes->get('/', 'Auth\Login::index');
$routes->get('/logindulu', 'Auth\Login::index');
$routes->post('/logindulu', 'Auth\Login::ceklogin');
$routes->get('/logout', 'Auth\Login::logout');
$routes->get('/ubah_password', 'Profile::ubahpss');
$routes->post('/ubah_password', 'Profile::submit_pssbaru');
// profile dan dashbard
// $routes->get('/profile', 'Profile::index');
$routes->get('/dashboard', 'Manager\Dashboard::index');
// customer
$routes->get('/customer', [App\Controllers\Customer::class, 'index']);
$routes->get('/faddcustomer', [App\Controllers\Customer::class, 'fadd']);
$routes->post('/simpancustomer', [App\Controllers\Customer::class, 'simpan']);
$routes->get('/feditcustomer', [App\Controllers\Customer::class, 'fedit']);
$routes->post('/updatecustomer', [App\Controllers\Customer::class, 'update']);
$routes->post('/delcustomer', [App\Controllers\Customer::class, 'delete']);
// invoice
$routes->get('/invoice', [App\Controllers\Invoice::class, 'index']);
$routes->get('/faddinvoice', [App\Controllers\Invoice::class, 'fadd']);
$routes->post('/simpaninvoice', [App\Controllers\Invoice::class, 'simpan']);
$routes->get('/feditinvoice', [App\Controllers\Invoice::class, 'fedit']);
$routes->post('/updateinvoice', [App\Controllers\Invoice::class, 'update']);
$routes->post('/delinvoice', [App\Controllers\Invoice::class, 'delete']);
$routes->post('/payinvoice', [App\Controllers\Invoice::class, 'pay']);
// pembayaran
$routes->get('/laporanabsensi', [App\Controllers\Pembayaran::class, 'index']);
$routes->get('/cetakinv/(:any)', [App\Controllers\Pembayaran::class, 'cetakinv/$1']);

//mata pelajaran
$routes->group('mata-pelajaran', ['namespace' => 'App\Controllers'], function($routes) {
    $routes->get('/', 'MataPelajaranController::index');
    $routes->get('fadd', 'MataPelajaranController::fadd');
    $routes->post('simpan', 'MataPelajaranController::simpan');
    $routes->get('fedit', 'MataPelajaranController::fedit');
    $routes->post('update', 'MataPelajaranController::update');
    $routes->post('delete', 'MataPelajaranController::delete');
});

//Siswa
$routes->group('siswa', ['namespace' => 'App\Controllers'], function($routes) {
    $routes->get('/', 'SiswaController::index');         // Menampilkan daftar siswa
    $routes->get('list', 'DaftarSiswaController::index');         // Menampilkan daftar siswa
    $routes->get('fadd', 'SiswaController::fadd');       // Menampilkan form tambah siswa
    $routes->post('simpan', 'SiswaController::simpan');  // Menyimpan data siswa baru
    $routes->get('fedit', 'SiswaController::fedit');     // Menampilkan form edit siswa
    $routes->post('update', 'SiswaController::update');  // Memperbarui data siswa
    $routes->post('delete', 'SiswaController::delete');  // Menghapus data siswa
    $routes->get('qrsiswa', 'QrSiswaController::index');
    $routes->get('generate_qr_codes_for_all', 'QrSiswaController::generateQrCodesForAll');
    $routes->get('fshow', 'QrSiswaController::fshow');
    $routes->get('uploads', 'QrSiswaController::showImage');
    $routes->get('absensi-siswa', 'QrSiswaController::indexAbsensiSiswa');

});

//Guru
$routes->group('guru', function($routes) {
    $routes->get('/', 'GuruController::index'); // Menampilkan daftar data guru
    $routes->match(['get', 'post'], 'fadd', 'GuruController::fadd'); // Form tambah data guru
    $routes->post('simpan', 'GuruController::simpan'); // Simpan data guru baru
    $routes->match(['get', 'post'], 'fedit', 'GuruController::fedit'); // Form edit data guru
    $routes->post('update', 'GuruController::update'); // Update data guru
    $routes->post('delete', 'GuruController::delete'); // Hapus data guru
    $routes->get('absensi', 'AbsensiController::index'); // Route untuk menampilkan semua data absensi
    $routes->get('absensi/fscan', 'AbsensiController::fscan');
    $routes->get('absensi/scanQrAbsensi', 'AbsensiController::keteranganAbsensi');
    $routes->post('absensi/tambah', 'AbsensiController::tambah');
    $routes->get('absensi/fadd', 'AbsensiController::fadd');

});

// Jadwal
$routes->group('jadwal', function($routes) {
    $routes->get('/', 'JadwalController::index'); // Menampilkan daftar jadwal
    $routes->get('fadd', 'JadwalController::fadd'); // Form tambah jadwal
    $routes->post('simpan', 'JadwalController::simpan'); // Simpan data jadwal
    $routes->get('fedit', 'JadwalController::fedit'); // Form edit jadwal
    $routes->post('update', 'JadwalController::update'); // Update data jadwal
    $routes->post('delete', 'JadwalController::delete'); // Hapus jadwal
    $routes->get('get-guru/(:num)', 'JadwalController::getGuru/$1');

});

//profile
$routes->group('profile', ['namespace' => 'App\Controllers'], function($routes) {
    $routes->get('/', 'Profile::index'); // Rute untuk menampilkan halaman profil
    $routes->get('ubah_password', 'Profile::ubahpss'); // Rute untuk menampilkan halaman ubah password
    $routes->post('submit_pssbaru', 'Profile::submit_pssbaru'); // Rute untuk memproses perubahan password
});

$routes->group('profile', function($routes) {
    // Routes untuk Admin
    $routes->get('/', 'Profile::index');                // Menampilkan halaman profil admin
    $routes->get('ubah_password', 'Profile::ubahpss');   // Menampilkan halaman ubah password admin
    $routes->post('ubah_password', 'Profile::submit_pssbaru'); // Mengirimkan data password baru admin
});

$routes->group('profile_guru', function($routes) {
    // Routes untuk Guru
    $routes->get('/', 'Profile_guru::index');           // Menampilkan halaman profil guru
    $routes->get('ubah_password', 'Profile_guru::ubahpss'); // Menampilkan halaman ubah password guru
    $routes->post('ubah_password', 'Profile_guru::submit_pssbaru'); // Mengirimkan data password baru guru
});

$routes->group('profile_siswa', function($routes) {
    // Routes untuk Siswa
    $routes->get('/', 'Profile_siswa::index');          // Menampilkan halaman profil siswa
    $routes->get('ubah_password', 'Profile_siswa::ubahpss'); // Menampilkan halaman ubah password siswa
    $routes->post('ubah_password', 'Profile_siswa::submit_pssbaru'); // Mengirimkan data password baru siswa
});

$routes->group('jadwal_pelajaran', function($routes) {
    // Routes untuk Siswa
    $routes->get('/', 'JadwalPelajaranController::index');          // Menampilkan halaman jadwal pelajaran
});






