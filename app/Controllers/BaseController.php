<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Models\MenuModel;
use App\Models\SubmenuModel;
use App\Models\AksesModel;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var list<string>
     */
    protected $helpers = [];

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    // protected $session;

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = \Config\Services::session();
    }
    public function tampil_menu($user_level_id)
    {
        $menuModel = new MenuModel();
        $aksesModel = new AksesModel();
        $dtlakses = $aksesModel->getMenu_akses($user_level_id)->getResult();
        $dtmenu = [];
        foreach ($dtlakses as $menu) {
            $dtmenu[$menu->nama] = $menuModel->getMenu($menu->akses_menu_id)->getResult();
        }
        return $dtmenu;
    }
    public function tampil_submenu($user_level_id)
    {
        $submenuModel = new SubmenuModel();
        $dtsubmenu = [];
        foreach ($this->tampil_menu($user_level_id) as $m) {
            foreach ($m as $ms) {
                if ($ms->punya_submenu == '1') {
                    $dtsubmenu[$ms->id] = $submenuModel->getSubmenu($ms->id)->getResult();
                }
            }
        }
        return $dtsubmenu;
    }
    public function nama_hari($hari)
    {
        $namaHari = [
            'Sun' => "Minggu",
            'Mon' => "Senin",
            'Tue' => "Selasa",
            'Wed' => "Rabu",
            'Thu' => "Kamis",
            'Fri' => "Jumat",
            'Sat' => "Sabtu"
        ];
        return $namaHari[$hari];
    }
}
