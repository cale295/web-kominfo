<?php
namespace App\Controllers\backend;
use CodeIgniter\Controller;
use App\Models\BeritaModel;
use App\Models\AgendaModel;
use App\Models\PhotoGalleryModel;
use App\Models\DokumentModel;
use App\Models\BeritaLogModel;
use App\Models\AccessRightsModel;

class DashboardController extends Controller
{
    public function index()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }
        
        $berita      = new BeritaModel();
        $agenda      = new AgendaModel();
        $gallery     = new PhotoGalleryModel();
        $document    = new DokumentModel();
        $beritaLog   = new BeritaLogModel();
        $accessModel = new AccessRightsModel();
        
        $userRole = session()->get('role');
        
        // Ambil access rights berdasarkan role user
        $accessRights = $accessModel->where('role', $userRole)->findAll();
        
        $today = date('Y-m-d');
        
        $data = [
            // Berita
            'total_berita'   => $berita->countAll(),
            'publish_berita' => $berita
                ->where('status_berita', 4)
                ->where('trash', '0')
                ->countAllResults(),
            'draft_berita'   => $berita
                ->where('status_berita', 0)
                ->where('trash', '0')
                ->countAllResults(),
            
            // Agenda
            'agenda_total'    => $agenda->countAll(),
            'agenda_upcoming' => $agenda->where('start_date >', $today)->countAllResults(),
            'agenda_done'     => $agenda->where('end_date <', $today)->countAllResults(),
            
            // Gallery
            'gallery_total'  => $gallery->countAll(),
            
            // Dokumen
            'document_total' => $document->countAll(),
            'document_new'   => $document->where('created_at >=', date('Y-m-01'))->countAllResults(),
            
            // Log
            'last_logs' => $beritaLog
                ->select('t_berita_log.*, m_users.username')
                ->join('m_users', 'm_users.id_user = t_berita_log.id_user', 'left')
                ->orderBy('t_berita_log.created_date', 'DESC')
                ->limit(5)
                ->find(),
            
            'user_role'      => $userRole,
            'access_rights'  => $accessRights,
        ];
        
        return view('/pages/Dashboard', $data);
    }
}