<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');
class List_ticket extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('model_app');


        if (!$this->session->userdata('id_user')) {
            $this->session->set_flashdata("msg", "<div class='alert alert-info'>
       <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
       <strong><span class='glyphicon glyphicon-remove-sign'></span></strong> Silahkan login terlebih dahulu.
       </div>");
            redirect('login');
        }
    }


    function ticket_list()
    {
        $data['header'] = "header/header";
        $data['navbar'] = "navbar/navbar";
        $data['sidebar'] = "sidebar/sidebar";
        $data['body'] = "body/list_ticket";


        $id_dept = trim($this->session->userdata('id_dept'));
        $id_divisi = trim($this->session->userdata('id_divisi'));
        $id_user = trim($this->session->userdata('id_user'));

        //notification 

        $sql_listticket = "SELECT COUNT(id_ticket) AS jml_list_ticket FROM ticket WHERE status = 2";
        $row_listticket = $this->db->query($sql_listticket)->row();

        $data['notif_list_ticket'] = $row_listticket->jml_list_ticket;

        //$sql_approvalticket = "SELECT COUNT(A.id_ticket) AS jml_approval_ticket FROM ticket A 
        //LEFT JOIN sub_kategori B ON B.id_sub_kategori = A.id_sub_kategori 
        //LEFT JOIN kategori C ON C.id_kategori = B.id_kategori
        //LEFT JOIN karyawan D ON D.nik = A.reported 
        //LEFT JOIN bagian_departemen E ON E.id_bagian_dept = D.id_bagian_dept WHERE E.id_dept = $id_dept AND status = 1";
        //$row_approvalticket = $this->db->query($sql_approvalticket)->row();

        $sql_approvalticket = "SELECT COUNT(A.id_ticket) AS jml_approval_ticket FROM ticket A 
        LEFT JOIN sub_kategori B ON B.id_sub_kategori = A.id_sub_kategori 
        LEFT JOIN kategori C ON C.id_kategori = B.id_kategori
        LEFT JOIN karyawan D ON D.nik = A.reported 
        LEFT JOIN departemen E ON E.id_dept = D.id_dept Where E.id_divisi AND status = 1";
        $row_approvalticket = $this->db->query($sql_approvalticket)->row();

        $data['notif_approval'] = $row_approvalticket->jml_approval_ticket;

        // $sql_assignmentticket = "SELECT COUNT(id_ticket) AS jml_assignment_ticket FROM ticket WHERE status = 3 AND id_teknisi='$id_user'";
        // $row_assignmentticket = $this->db->query($sql_assignmentticket)->row();

        $sql_assignmentticket = "SELECT COUNT(id_ticket) AS jml_assignment_ticket FROM ticket A 
        left join teknisi T on T.id_teknisi = A.id_teknisi
        inner join karyawan D on D.nik = T.nik
        where D.nik ='$id_user' AND A.status = 3";
        $row_assignmentticket = $this->db->query($sql_assignmentticket)->row();

        $data['notif_assignment'] = $row_assignmentticket->jml_assignment_ticket;

        //notif pending _adm
        $sql_pending_adm = "SELECT COUNT(id_ticket) AS jml_pending_adm FROM ticket A 
        left join teknisi T on T.id_teknisi = A.id_teknisi
        WHERE A.status IN (6, 7, 8)";

        $row_pending_adm = $this->db->query($sql_pending_adm)->row();
        $data['notif_pending_adm'] = $row_pending_adm->jml_pending_adm;

        //end notification

        $datalist_ticket = $this->model_app->datalist_ticket1();
        $data['datalist_ticket'] = $datalist_ticket;

        $this->load->view('template', $data);
    }


    function pilih_teknisi($id)
    {
        $data['header'] = "header/header";
        $data['navbar'] = "navbar/navbar";
        $data['sidebar'] = "sidebar/sidebar";
        $data['body'] = "body/pilih_teknisi";

        $id_dept = trim($this->session->userdata('id_dept'));
        $id_user = trim($this->session->userdata('id_user'));

        //notification 

        $sql_listticket = "SELECT COUNT(id_ticket) AS jml_list_ticket FROM ticket WHERE status = 2";
        $row_listticket = $this->db->query($sql_listticket)->row();

        $data['notif_list_ticket'] = $row_listticket->jml_list_ticket;

        //$sql_approvalticket = "SELECT COUNT(A.id_ticket) AS jml_approval_ticket FROM ticket A 
        //LEFT JOIN sub_kategori B ON B.id_sub_kategori = A.id_sub_kategori 
        //LEFT JOIN kategori C ON C.id_kategori = B.id_kategori
        //LEFT JOIN karyawan D ON D.nik = A.reported 
        //LEFT JOIN bagian_departemen E ON E.id_bagian_dept = D.id_bagian_dept WHERE E.id_dept = $id_dept AND status = 1";
        //$row_approvalticket = $this->db->query($sql_approvalticket)->row();

        $sql_approvalticket = "SELECT COUNT(A.id_ticket) AS jml_approval_ticket FROM ticket A 
        LEFT JOIN sub_kategori B ON B.id_sub_kategori = A.id_sub_kategori 
        LEFT JOIN kategori C ON C.id_kategori = B.id_kategori
        LEFT JOIN karyawan D ON D.nik = A.reported 
        LEFT JOIN departemen E ON E.id_dept = D.id_dept Where E.id_divisi AND status = 1";
        $row_approvalticket = $this->db->query($sql_approvalticket)->row();

        $data['notif_approval'] = $row_approvalticket->jml_approval_ticket;

        // $sql_assignmentticket = "SELECT COUNT(id_ticket) AS jml_assignment_ticket FROM ticket WHERE status = 3 AND id_teknisi='$id_user'";
        // $row_assignmentticket = $this->db->query($sql_assignmentticket)->row();

        $sql_assignmentticket = "SELECT COUNT(id_ticket) AS jml_assignment_ticket FROM ticket A 
        left join teknisi T on T.id_teknisi = A.id_teknisi
        inner join karyawan D on D.nik = T.nik
        where D.nik ='$id_user' AND A.status = 3";
        $row_assignmentticket = $this->db->query($sql_assignmentticket)->row();

        $data['notif_assignment'] = $row_assignmentticket->jml_assignment_ticket;

        //notif pending _adm
        $sql_pending_adm = "SELECT COUNT(id_ticket) AS jml_pending_adm FROM ticket A 
        left join teknisi T on T.id_teknisi = A.id_teknisi
        WHERE A.status IN (6, 7, 8)";

        $row_pending_adm = $this->db->query($sql_pending_adm)->row();
        $data['notif_pending_adm'] = $row_pending_adm->jml_pending_adm;

        //end notification

        $sql = "SELECT A.status, D.nama_karyawan, C.id_kategori, A.id_ticket, A.tanggal, A.problem_summary, A.problem_detail, B.nama_sub_kategori, C.nama_kategori, E.nama
                FROM ticket A 
                LEFT JOIN sub_kategori B ON B.id_sub_kategori = A.id_sub_kategori
                LEFT JOIN kategori C ON C.id_kategori = B.id_kategori 
                LEFT JOIN karyawan D ON D.nik = A.reported 
                left join tb_pegawai E ON E.nik = A.reported
                WHERE A.id_ticket = '$id'";

        $row = $this->db->query($sql)->row();

        $id_kategori = $row->id_kategori;

        $data['url'] = "list_ticket/assignment";

        $data['dd_teknisi'] = $this->model_app->dropdown_teknisi($id_kategori);
        $data['id_teknisi'] = "";

        $data['id_ticket'] = $id;
        $data['tanggal'] = $row->tanggal;
        $data['nama_sub_kategori'] = $row->nama_sub_kategori;
        $data['nama_kategori'] = $row->nama_kategori;
        $data['reported'] = $row->nama_karyawan;
        $data['reported2'] = $row->nama;
        $data['problem_summary'] = $row->problem_summary;
        $data['problem_detail'] = $row->problem_detail;

        // $tracking['nama'] = $this->session->userdata('nama_user');
        // $this->db->insert('tracking', $tracking);

        $this->load->view('template', $data);
    }


    function assignment()
    {

        $id_ticket = strtoupper(trim($this->input->post('id_ticket')));
        $id_teknisi = strtoupper(trim($this->input->post('id_teknisi')));

        $id_user = trim($this->session->userdata('id_user'));
        $tanggal = $time = date("Y-m-d  H:i:s");

        $data['id_teknisi'] = $id_teknisi;
        $data['status'] = 3;


        $tracking['id_ticket'] = $id_ticket;
        $tracking['tanggal'] = $tanggal;
        $tracking['status'] = "Pemilihan Teknisi";
        $tracking['deskripsi'] = "TICKET DIBERIKAN KEPADA TEKNISI";
        $tracking['id_user'] = $id_user;
        $tracking['nama'] = $this->session->userdata('nama_user');

        $this->db->trans_start();

        $this->db->where('id_ticket', $id_ticket);
        $this->db->update('ticket', $data);

        $this->db->insert('tracking', $tracking);

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->session->set_flashdata("msg", "<div class='alert bg-danger' role='alert'>
                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                <svg class='glyph stroked empty-message'><use xlink:href='#stroked-empty-message'></use></svg> Data gagal tersimpan.
                </div>");
            redirect('list_ticket/ticket_list');
        } else {
            $this->session->set_flashdata("msg", "<div class='alert bg-success' role='alert'>
                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                <svg class='glyph stroked empty-message'><use xlink:href='#stroked-empty-message'></use></svg> Data tersimpan.
                </div>");
            redirect('list_ticket/ticket_list');
        }
    }

    function view_progress_teknisi($id)
    {

        $data['header'] = "header/header";
        $data['navbar'] = "navbar/navbar";
        $data['sidebar'] = "sidebar/sidebar";
        $data['body'] = "body/progress_teknisi";

        $id_dept = trim($this->session->userdata('id_dept'));
        $id_user = trim($this->session->userdata('id_user'));

        //notification 

        $sql_listticket = "SELECT COUNT(id_ticket) AS jml_list_ticket FROM ticket WHERE status = 2";
        $row_listticket = $this->db->query($sql_listticket)->row();

        $data['notif_list_ticket'] = $row_listticket->jml_list_ticket;

        //$sql_approvalticket = "SELECT COUNT(A.id_ticket) AS jml_approval_ticket FROM ticket A 
        //LEFT JOIN sub_kategori B ON B.id_sub_kategori = A.id_sub_kategori 
        //LEFT JOIN kategori C ON C.id_kategori = B.id_kategori
        //LEFT JOIN karyawan D ON D.nik = A.reported 
        //LEFT JOIN bagian_departemen E ON E.id_bagian_dept = D.id_bagian_dept WHERE E.id_dept = $id_dept AND status = 1";
        //$row_approvalticket = $this->db->query($sql_approvalticket)->row();

        $sql_approvalticket = "SELECT COUNT(A.id_ticket) AS jml_approval_ticket FROM ticket A 
        LEFT JOIN sub_kategori B ON B.id_sub_kategori = A.id_sub_kategori 
        LEFT JOIN kategori C ON C.id_kategori = B.id_kategori
        LEFT JOIN karyawan D ON D.nik = A.reported 
        LEFT JOIN departemen E ON E.id_dept = D.id_dept Where E.id_divisi AND status = 1";
        $row_approvalticket = $this->db->query($sql_approvalticket)->row();


        $data['notif_approval'] = $row_approvalticket->jml_approval_ticket;

        // $sql_assignmentticket = "SELECT COUNT(id_ticket) AS jml_assignment_ticket FROM ticket WHERE status = 3 AND id_teknisi='$id_user'";
        // $row_assignmentticket = $this->db->query($sql_assignmentticket)->row();

        $sql_assignmentticket = "SELECT COUNT(id_ticket) AS jml_assignment_ticket FROM ticket A 
        left join teknisi T on T.id_teknisi = A.id_teknisi
        inner join karyawan D on D.nik = T.nik
        where D.nik ='$id_user' AND A.status = 3";
        $row_assignmentticket = $this->db->query($sql_assignmentticket)->row();

        $data['notif_assignment'] = $row_assignmentticket->jml_assignment_ticket;

        //notif pending _adm
        $sql_pending_adm = "SELECT COUNT(id_ticket) AS jml_pending_adm FROM ticket A 
        left join teknisi T on T.id_teknisi = A.id_teknisi
        WHERE A.status IN (6, 7, 8)";

        $row_pending_adm = $this->db->query($sql_pending_adm)->row();
        $data['notif_pending_adm'] = $row_pending_adm->jml_pending_adm;
        //end notification

        $sql = "SELECT A.status, A.progress, A.tanggal,  A.tanggal_proses, A.tanggal_solved, A.problem_summary, A.problem_detail, F.nama_karyawan AS nama_teknisi, D.nama_karyawan, C.id_kategori, A.id_ticket, A.tanggal, B.nama_sub_kategori, C.nama_kategori, G.nama AS nama_teknisi, H.nama
                FROM ticket A 
                LEFT JOIN sub_kategori B ON B.id_sub_kategori = A.id_sub_kategori
                LEFT JOIN kategori C ON C.id_kategori = B.id_kategori 
                LEFT JOIN karyawan D ON D.nik = A.reported 
                LEFT JOIN teknisi E ON E.id_teknisi = A.id_teknisi
                LEFT JOIN karyawan F ON F.nik = E.nik
                LEFT JOIN tb_pegawai G ON G.nik = E.nik
                LEFT JOIN tb_pegawai H ON H.nik = A.reported
                WHERE A.id_ticket = '$id'";

        $row = $this->db->query($sql)->row();

        $id_kategori = $row->id_kategori;

        $data['dd_teknisi'] = $this->model_app->dropdown_teknisi($id_kategori);
        $data['id_teknisi'] = "";

        $data['id_ticket'] = $id;
        $data['nama_teknisi'] = $row->nama_teknisi;
        $data['tanggal'] = $row->tanggal;
        $data['nama_sub_kategori'] = $row->nama_sub_kategori;
        $data['nama_kategori'] = $row->nama_kategori;
        // $data['reported'] = $row->nama_karyawan;
        $data['reported'] = $row->nama;
        $data['problem_summary'] = $row->problem_summary;
        $data['problem_detail'] = $row->problem_detail;
        $data['progress'] = $row->progress;
        $data['status'] = $row->status;
        $data['tanggal_proses'] = $row->tanggal_proses;

        $data['tanggal'] = $row->tanggal;
        $data['tanggal_solved'] = $row->tanggal_solved;

        //TRACKING TICKET
        $data_trackingticket = $this->model_app->data_trackingticket($id);
        $data['data_trackingticket'] = $data_trackingticket;


        $this->load->view('template', $data);
    }

    public function pdflistticket()
    {
        ob_end_clean();
        // $id = trim($this->session->userdata('id_user'));

        $datalist_ticket = $this->model_app->datalist_ticketnew();
        $data['datalist_ticket'] = $datalist_ticket;


        ob_start();
        $content = $this->load->view('body/pdflistticket', $data);
        $content = ob_get_clean();
        $this->load->library('html2pdf');
        try {
            $html2pdf = new HTML2PDF('L', 'A4', 'en');
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            // $html2pdf->Output('Report_ppic.pdf');
            echo ("<script>window.print()</script>");
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }
    public function pdflistticket1()
    {
        ob_end_clean();
        $id = trim($this->session->userdata('id_user'));
        $datalist_ticket = $this->model_app->datalist_ticketnew();
        $data['datalist_ticket'] = $datalist_ticket;


        ob_start();
        $content = $this->load->view('body/pdflistticket', $data);
        $content = ob_get_clean();

        // echo $content;
        $this->load->library('html2pdf');
        try {
            $html2pdf = new HTML2PDF('L', 'A4', 'en');
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            // ob_clean();
            // $html2pdf->output();
            echo ("<script>window.print()</script>");
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }
    public function pdflistticket2()
    {
        ob_end_clean();
        // require_once('../../asset/html2pdf-4.03/html2pdf.class.php');

        $datalist_ticket = $this->model_app->datalist_ticket1();
        $data['datalist_ticket'] = $datalist_ticket;


        ob_start();
        $content = $this->load->view('body/pdflistticket', $data);
        $content = ob_get_clean();
        $this->load->library('html2pdf');

        try {
            $html2pdf = new HTML2PDF('L', 'A4', 'en');
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            // ob_clean();
            // $html2pdf->Output('Report_ppic.pdf');
            // $html2pdf->Output('Report_ppic.pdf');
            echo ("<script>window.print()</script>");
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }
}
