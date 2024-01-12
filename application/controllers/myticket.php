<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');
class Myticket extends CI_Controller
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


    function myticket_list()
    {

        $data['header'] = "header/header";
        $data['navbar'] = "navbar/navbar";
        $data['sidebar'] = "sidebar/sidebar";
        $data['body'] = "body/myticket";

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
        LEFT JOIN tb_pegawai P ON P.nik = A.reported where status = 1";
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

        //notif pending

        $sql_pending = "SELECT COUNT(id_ticket) AS jml_pending FROM ticket A 
        left join teknisi T on T.id_teknisi = A.id_teknisi
        WHERE A.reported = '$id_user' AND A.status IN (6,7,8 )";
        $row_pending = $this->db->query($sql_pending)->row();

        $data['notif_pending'] = $row_pending->jml_pending;

        //notif pending _adm
        $sql_pending_adm = "SELECT COUNT(id_ticket) AS jml_pending_adm FROM ticket A 
        left join teknisi T on T.id_teknisi = A.id_teknisi
        WHERE A.status IN (6, 7, 8)";

        $row_pending_adm = $this->db->query($sql_pending_adm)->row();
        $data['notif_pending_adm'] = $row_pending_adm->jml_pending_adm;
        //end notification

        $id = trim($this->session->userdata('id_user'));

        $datamyticket = $this->model_app->datamyticket($id_user);
        $data['datamyticket'] = $datamyticket;

        $this->load->view('template', $data);
    }


    function myticket_detail($id)
    {
        $data['header'] = "header/header";
        $data['navbar'] = "navbar/navbar";
        $data['sidebar'] = "sidebar/sidebar";
        $data['body'] = "body/progress_teknisi";
        $id_user = trim($this->session->userdata('id_user'));


        $sql = "SELECT A.status, A.progress,A.tanggal, A.tanggal_solved, A.tanggal_proses, A.tanggal_solved,A.problem_summary, A.problem_detail, F.nama_karyawan AS nama_teknisi, D.nama_karyawan, C.id_kategori, A.id_ticket, A.tanggal, B.nama_sub_kategori, C.nama_kategori
                FROM ticket A 
                LEFT JOIN sub_kategori B ON B.id_sub_kategori = A.id_sub_kategori
                LEFT JOIN kategori C ON C.id_kategori = B.id_kategori 
                LEFT JOIN karyawan D ON D.nik = A.reported 
                LEFT JOIN teknisi E ON E.id_teknisi = A.id_teknisi
                LEFT JOIN karyawan F ON F.nik = E.nik 
                WHERE A.id_ticket = '$id'";

        $cari_data2 = "SELECT A.status, A.progress,A.tanggal, A.tanggal_solved, A.tanggal_proses, A.tanggal_solved,A.problem_summary, A.problem_detail, F.nama AS nama_teknisi, D.nama, C.id_kategori, A.id_ticket, A.tanggal, B.nama_sub_kategori, C.nama_kategori
                FROM ticket A 
                LEFT JOIN sub_kategori B ON B.id_sub_kategori = A.id_sub_kategori
                LEFT JOIN kategori C ON C.id_kategori = B.id_kategori 
                LEFT JOIN tb_pegawai D ON D.nik = A.reported
                LEFT JOIN teknisi E ON E.id_teknisi = A.id_teknisi
                -- LEFT JOIN karyawan F ON F.nik = E.nik 
                LEFT JOIN tb_pegawai F ON F.nik = E.nik 
                WHERE A.id_ticket = '$id'";
        $row = $this->db->query($sql)->row();
        $row2 = $this->db->query($cari_data2)->row();

        $id_kategori = $row->id_kategori;

        $data['dd_teknisi'] = $this->model_app->dropdown_teknisi($id_kategori);
        $data['id_teknisi'] = "";

        $data['id_ticket'] = $id;
        $data['nama_teknisi'] = $row2->nama_teknisi;
        $data['tanggal'] = $row->tanggal;
        $data['nama_sub_kategori'] = $row->nama_sub_kategori;
        $data['nama_kategori'] = $row->nama_kategori;
        // $data['reported'] = $row->nama;
        $data['reported'] = $row2->nama;
        $data['problem_summary'] = $row->problem_summary;
        $data['problem_detail'] = $row->problem_detail;
        $data['progress'] = $row->progress;
        $data['status'] = $row->status;
        $data['tanggal_proses'] = $row->tanggal_proses;

        $data['tanggal'] = $row->tanggal;
        $data['tanggal_solved'] = $row->tanggal_solved;


        $sql_listticket = "SELECT COUNT(id_ticket) AS jml_list_ticket FROM ticket WHERE status = 2";
        $row_listticket = $this->db->query($sql_listticket)->row();

        $data['notif_list_ticket'] = $row_listticket->jml_list_ticket;

        $sql_approvalticket = "SELECT COUNT(A.id_ticket) AS jml_approval_ticket FROM ticket A 
        LEFT JOIN sub_kategori B ON B.id_sub_kategori = A.id_sub_kategori 
        LEFT JOIN kategori C ON C.id_kategori = B.id_kategori
        LEFT JOIN tb_pegawai P ON P.nik = A.reported where status = 1";
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

        //notif pending

        $sql_pending = "SELECT COUNT(id_ticket) AS jml_pending FROM ticket A 
        left join teknisi T on T.id_teknisi = A.id_teknisi
        WHERE A.reported = '$id_user' AND A.status IN (6, 7, 8) ";
        $row_pending = $this->db->query($sql_pending)->row();

        $data['notif_pending'] = $row_pending->jml_pending;

        //notif pending _adm
        $sql_pending_adm = "SELECT COUNT(id_ticket) AS jml_pending_adm FROM ticket A 
        left join teknisi T on T.id_teknisi = A.id_teknisi
        WHERE A.status IN (6, 7, 8)";

        $row_pending_adm = $this->db->query($sql_pending_adm)->row();
        $data['notif_pending_adm'] = $row_pending_adm->jml_pending_adm;
        //end notification

        //TRACKING TICKET
        $data_trackingticket = $this->model_app->data_trackingticket($id);
        $data['data_trackingticket'] = $data_trackingticket;


        $this->load->view('template', $data);
    }


    function feedback_yes($id_ticket, $id_teknisi)
    {



        $id_user = trim($this->session->userdata('id_user'));
        $tanggal = $time = date("Y-m-d  H:i:s");

        $data['feedback'] = 1;
        $data['reported'] = $id_user;
        $data['id_ticket'] = $id_ticket;


        $sql_teknisi = "SELECT * FROM teknisi WHERE id_teknisi = '$id_teknisi'";
        $row = $this->db->query($sql_teknisi)->row();

        $data2['point'] = $row->point + 1;

        $this->db->trans_start();

        $this->db->insert('history_feedback', $data);

        $this->db->where('id_teknisi', $id_teknisi);
        $this->db->update('teknisi', $data2);

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {

            redirect('myticket/myticket_list');
        } else {

            redirect('myticket/myticket_list');
        }
    }

    function feedback_no($id_ticket, $id_teknisi)
    {



        $id_user = trim($this->session->userdata('id_user'));
        $tanggal = $time = date("Y-m-d  H:i:s");

        $data['feedback'] = 0;
        $data['reported'] = $id_user;
        $data['id_ticket'] = $id_ticket;

        $sql_teknisi = "SELECT * FROM teknisi WHERE id_teknisi = '$id_teknisi'";
        $row = $this->db->query($sql_teknisi)->row();

        $data2['point'] = $row->point - 1;

        $this->db->trans_start();

        $this->db->insert('history_feedback', $data);

        $this->db->where('id_teknisi', $id_teknisi);
        $this->db->update('teknisi', $data2);

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {

            redirect('myticket/myticket_list');
        } else {

            redirect('myticket/myticket_list');
        }
    }

    public function pdfmyticket()
    {
        ob_end_clean();
        $id = trim($this->session->userdata('id_user'));

        $datamyticket = $this->model_app->datamyticket($id);
        $data['datamyticket'] = $datamyticket;


        ob_start();
        $content = $this->load->view('body/pdfmyticket', $data);
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
}
