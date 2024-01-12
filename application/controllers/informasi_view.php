<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Informasi_view extends CI_Controller
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


    function index()
    {
        $data['header'] = "header/header";
        $data['navbar'] = "navbar/navbar";
        $data['sidebar'] = "sidebar/sidebar";
        $data['body'] = "body/news";

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

        // where D.nik ='$id_user' AND A.status = 3";

        $sql_assignmentticket = "SELECT COUNT(id_ticket) AS jml_assignment_ticket FROM ticket A 
        left join teknisi T on T.id_teknisi = A.id_teknisi
        inner join tb_pegawai D on D.nik = T.nik
        WHERE D.nik ='$id_user' AND (A.status = 3 OR A.status = 5)";
        $row_assignmentticket = $this->db->query($sql_assignmentticket)->row();

        $data['notif_assignment'] = $row_assignmentticket->jml_assignment_ticket;

        //notif pending

        $sql_pending = "SELECT COUNT(id_ticket) AS jml_pending FROM ticket A 
        left join teknisi T on T.id_teknisi = A.id_teknisi
        WHERE A.reported = '$id_user' AND A.status IN (6,7,8) ";
        $row_pending = $this->db->query($sql_pending)->row();

        $data['notif_pending'] = $row_pending->jml_pending;

        //notif pending _adm
        $sql_pending_adm = "SELECT COUNT(id_ticket) AS jml_pending_adm FROM ticket A 
        left join teknisi T on T.id_teknisi = A.id_teknisi
        WHERE A.status IN (6,7, 8)";

        $row_pending_adm = $this->db->query($sql_pending_adm)->row();
        $data['notif_pending_adm'] = $row_pending_adm->jml_pending_adm;
        //end notification

        $datainformasi = $this->model_app->datainformasi();
        $data['datainformasi'] = $datainformasi;


        $this->load->view('template', $data);
    }
}
