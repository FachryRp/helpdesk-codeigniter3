<?php
defined('BASEPATH') or exit('No direct script access allowed');

class profile extends CI_Controller
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


    function view()
    {
        $data['header'] = "header/header";
        $data['navbar'] = "navbar/navbar";
        $data['sidebar'] = "sidebar/sidebar";
        $data['body'] = "body/profile";

        $id_dept = trim($this->session->userdata('id_dept'));
        $id_user = trim($this->session->userdata('id_user'));

        //notification 

        $sql_listticket = "SELECT COUNT(id_ticket) AS jml_list_ticket FROM ticket WHERE status = 2";
        $row_listticket = $this->db->query($sql_listticket)->row();

        $data['notif_list_ticket'] = $row_listticket->jml_list_ticket;

        // $sql_approvalticket = "SELECT COUNT(A.id_ticket) AS jml_approval_ticket FROM ticket A 
        // LEFT JOIN sub_kategori B ON B.id_sub_kategori = A.id_sub_kategori 
        // LEFT JOIN kategori C ON C.id_kategori = B.id_kategori
        // LEFT JOIN karyawan D ON D.nik = A.reported 
        // LEFT JOIN bagian_departemen E ON E.id_bagian_dept = D.id_bagian_dept WHERE E.id_dept = $id_dept AND status = 1";
        // $row_approvalticket = $this->db->query($sql_approvalticket)->row();

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

        $id = $this->session->userdata('id_user');


        // $sql =
        //     "SELECT A.nik, A.nama, A.alamat, A.jk, B.level, B.level, C.nama_jabatan, D.nama_bagian_dept, E.nama_dept, C.nama_jabatan 
        // FROM KARYAWAN A 
        // LEFT JOIN user B ON B.username = A.nik 
        // LEFT JOIN jabatan C ON C.id_jabatan = A.id_jabatan 
        // LEFT JOIN bagian_departemen D ON D.id_bagian_dept = A.id_bagian_dept 
        // LEFT JOIN departemen E ON E.id_dept = D.id_dept WHERE A.nik ='$id'";
        $sql =
            "SELECT A.nik, A.nama, A.alamat, A.jk, B.level, B.level, C.nama_jabatan, D.nama_dept, E.nama_divisi, C.nama_jabatan 
        FROM KARYAWAN A 
        LEFT JOIN user B ON B.username = A.nik 
        LEFT JOIN jabatan C ON C.id_jabatan = A.id_jabatan 
        LEFT JOIN departemen D ON D.id_dept = A.id_dept 
        LEFT JOIN divisi E ON E.id_divisi = D.id_divisi WHERE A.nik ='$id'";

        $row = $this->db->query($sql)->row();

        //general
        $data['nik'] = $row->nik;
        $data['nama'] = $row->nama;
        $data['alamat'] = $row->alamat;
        $data['jk'] = $row->jk;

        //info jabatan
        $data['jabatan'] = $row->nama_jabatan;
        $data['dept'] = $row->nama_dept;
        $data['divisi'] = $row->nama_divisi;
        $data['level'] = $row->level;

        $this->load->view('template', $data);
    }
}
