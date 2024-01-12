<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');
class Approval extends CI_Controller
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





    function approval_list()
    {

        $data['header'] = "header/header";
        $data['navbar'] = "navbar/navbar";
        $data['sidebar'] = "sidebar/sidebar";
        $data['body'] = "body/approval";

        $id_dept = trim($this->session->userdata('id_dept'));
        $id_divisi = trim($this->session->userdata('id_divisi'));
        $id_user = trim($this->session->userdata('id_user'));
        $nama_user = ($this->session->userdata('nama Karyawan'));

        //notification 

        $sql_listticket = "SELECT COUNT(id_ticket) AS jml_list_ticket FROM ticket WHERE status = 2";
        $row_listticket = $this->db->query($sql_listticket)->row();

        $data['notif_list_ticket'] = $row_listticket->jml_list_ticket;

        // $sql_approvalticket = "SELECT COUNT(A.id_ticket) AS jml_approval_ticket FROM ticket A 
        // LEFT JOIN sub_kategori B ON B.id_sub_kategori = A.id_sub_kategori 
        // LEFT JOIN kategori C ON C.id_kategori = B.id_kategori
        // LEFT JOIN karyawan D ON D.nik = A.reported
        // LEFT JOIN tb_pegawai P ON P.nik = A.reported
        // LEFT JOIN departemen E ON E.id_dept = D.id_dept Where E.id_divisi AND status = 1";
        // $row_approvalticket = $this->db->query($sql_approvalticket)->row();
        $sql_approvalticket = "SELECT COUNT(A.id_ticket) AS jml_approval_ticket FROM ticket A 
        LEFT JOIN sub_kategori B ON B.id_sub_kategori = A.id_sub_kategori 
        LEFT JOIN kategori C ON C.id_kategori = B.id_kategori
        LEFT JOIN tb_pegawai P ON P.nik = A.reported where status = 1";
        $row_approvalticket = $this->db->query($sql_approvalticket)->row();

        $data['notif_approval'] = $row_approvalticket->jml_approval_ticket;

        $sql_assignmentticket = "SELECT COUNT(id_ticket) AS jml_assignment_ticket FROM ticket A 
        left join teknisi T on T.id_teknisi = A.id_teknisi
        inner join karyawan D on D.nik = T.nik
        where D.nik ='$id_user' AND A.status = 3";
        $row_assignmentticket = $this->db->query($sql_assignmentticket)->row();

        $data['notif_assignment'] = $row_assignmentticket->jml_assignment_ticket;

        //notif pending _adm
        $sql_pending_adm = "SELECT COUNT(id_ticket) AS jml_pending_adm FROM ticket A 
        left join teknisi T on T.id_teknisi = A.id_teknisi
        WHERE A.status IN (6, 8)";

        $row_pending_adm = $this->db->query($sql_pending_adm)->row();
        $data['notif_pending_adm'] = $row_pending_adm->jml_pending_adm;

        //end notification

        $data['link'] = "approval_kabag/hapus";



        $dataapproval = $this->model_app->dataapprovalnew();
        $data['dataapproval'] = $dataapproval;


        $this->load->view('template', $data);
    }

    function approval_no($ticket)
    {

        $data['status'] = 0;

        $id_user = trim($this->session->userdata('id_user'));
        $tanggal = $time = date("Y-m-d  H:i:s");

        $tracking['id_ticket'] = $ticket;
        $tracking['tanggal'] = $tanggal;
        $tracking['status'] = "Ticket tidak disetujui";
        $tracking['deskripsi'] = "";
        $tracking['id_user'] = $id_user;


        $this->db->trans_start();

        $this->db->where('id_ticket', $ticket);
        $this->db->update('ticket', $data);

        $this->db->insert('tracking', $tracking);

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {

            redirect('approval/approval_list');
        } else {

            redirect('approval/approval_list');
        }
    }

    function approval_reaction($ticket)
    {

        $data['status'] = 1;

        $id_user = trim($this->session->userdata('id_user'));
        $tanggal = $time = date("Y-m-d  H:i:s");

        $tracking['id_ticket'] = $ticket;
        $tracking['tanggal'] = $tanggal;
        $tracking['status'] = "Ticket dikembalikan ke posisi belum di setujui";
        $tracking['deskripsi'] = "";
        $tracking['id_user'] = $id_user;
        $tracking['nama'] = $this->session->userdata('nama_user');


        $this->db->trans_start();

        $this->db->where('id_ticket', $ticket);
        $this->db->update('ticket', $data);

        $this->db->insert('tracking', $tracking);

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {

            redirect('approval/approval_list');
        } else {

            redirect('approval/approval_list');
        }
    }

    function approval_yes($ticket)
    {

        $data['status'] = 2;

        $id_user = trim($this->session->userdata('id_user'));
        $tanggal = $time = date("Y-m-d  H:i:s");

        $tracking['id_ticket'] = $ticket;
        $tracking['tanggal'] = $tanggal;
        $tracking['status'] = "Ticket disetujui";
        $tracking['deskripsi'] = "";
        $tracking['id_user'] = $id_user;
        $tracking['nama'] = $this->session->userdata('nama_user');

        $this->db->trans_start();

        $this->db->where('id_ticket', $ticket);
        $this->db->update('ticket', $data);

        $this->db->insert('tracking', $tracking);

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {

            redirect('approval/approval_list');
        } else {

            redirect('approval/approval_list');
        }
    }

    function hapus()
    {
        $id = $_POST['id'];

        $this->db->trans_start();

        $this->db->where('id_jabatan', $id);
        $this->db->delete('jabatan');

        $this->db->trans_complete();
    }

    function approval()
    {

        $data['header'] = "header/header";
        $data['navbar'] = "navbar/navbar";
        $data['sidebar'] = "sidebar/sidebar";
        $data['body'] = "body/form_jabatan";

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

        //end notification

        $data['url'] = "jabatan/save";

        $data['id_jabatan'] = "";
        $data['nama_jabatan'] = "";


        $this->load->view('template', $data);
    }

    function approval_requestorlist()
    {
        $data['header'] = "header/header";
        $data['navbar'] = "navbar/navbar";
        $data['sidebar'] = "sidebar/sidebar";
        $data['body'] = "body/approval_requestor";

        // $id_dept = trim($this->session->userdata('id_dept'));
        // $id_divisi = trim($this->session->userdata('id_divisi'));
        $id_user = trim($this->session->userdata('id_user'));

        //notif pending
        // -- WHERE A.reported = '$id_user' AND A.status = 6 OR A.status = 8 ";
        $sql_listticket = "SELECT COUNT(id_ticket) AS jml_list_ticket FROM ticket WHERE status = 2";
        $row_listticket = $this->db->query($sql_listticket)->row();

        $data['notif_list_ticket'] = $row_listticket->jml_list_ticket;

        $sql_pending = "SELECT COUNT(id_ticket) AS jml_pending FROM ticket A 
        left join teknisi T on T.id_teknisi = A.id_teknisi
        WHERE A.reported = '$id_user' AND A.status IN (6,7,8)";
        $row_pending = $this->db->query($sql_pending)->row();

        $data['notif_pending'] = $row_pending->jml_pending;

        // $sql_pending = "SELECT COUNT(id_ticket) AS jml_pending FROM ticket A 
        // left join teknisi T on T.id_teknisi = A.id_teknisi
        // inner join karyawan D on D.nik = T.nik
        // WHERE D.nik ='$id_user' AND A.status = 8 ";
        // $row_pending = $this->db->query($sql_pending)->row();

        // $data['notif_pending'] = $row_pending->jml_pending;

        $dataapproval_requestor = $this->model_app->dataapproval_requestor($id_user);
        $data['dataapproval_requestor'] = $dataapproval_requestor;


        $this->load->view('template', $data);
    }
    function approval_requestordetail()
    {
    }
    function approval_keterangan($id)
    {
        $data['header'] = "header/header";
        $data['navbar'] = "navbar/navbar";
        $data['sidebar'] = "sidebar/sidebar";
        $data['body'] = "body/formpending";

        $id_teknisi = trim($this->session->userdata('id_teknisi'));
        $tanggal = $time = date("Y-m-d  H:i:s");

        // $cari_data = "select A.nik, A.nama, C.nama_divisi, B.nama_dept FROM karyawan A
        // inner JOIN departemen B ON B.id_dept = A.id_dept
        // inner JOIN divisi C ON C.id_divisi = B.id_divisi
        // WHERE A.nik = '$id_teknisi'";

        // $row = $this->db->query($cari_data)->row();



        $sql = "SELECT A.progress, A.status, D.nama, C.id_kategori, A.id_ticket, A.tanggal, A.problem_summary, A.problem_detail, B.nama_sub_kategori, C.nama_kategori
                FROM ticket A 
                LEFT JOIN sub_kategori B ON B.id_sub_kategori = A.id_sub_kategori
                LEFT JOIN kategori C ON C.id_kategori = B.id_kategori 
                LEFT JOIN karyawan D ON D.nik = A.reported 
                WHERE A.id_ticket = '$id'";

        $row = $this->db->query($sql)->row();

        $data['id_teknisi'] = $id_teknisi;
        $data['id_ticket'] = $id;
        // $data['keterangan_pending'] = "";
        $data['deskripsi'] = "";
        $data['status'] = 8;
        $data['url1'] = "approval/approval_keterangan_save";

        $this->load->view('template', $data);

        if ($this->db->trans_status() === FALSE) {

            redirect('myassignment/myassignment_list');
        } else {

            redirect('myassignment/myassignment_list');
        }
    }

    function approval_keterangan_save()
    {
        $tracking['id_ticket'] = strtoupper(trim($this->input->post('id_ticket')));
        $tracking['tanggal'] = date("Y-m-d  H:i:s");
        $tracking['status'] = "Pending oleh teknisi";
        $tracking['deskripsi'] = trim($this->input->post('deskripsi'));
        // $tracking['keterangan_pending'] = trim($this->input->post('keterangan_pending'));
        $tracking['id_user'] = trim($this->session->userdata('id_user'));
        $tracking['nama'] = trim($this->session->userdata('nama_user'));

        $ticket = strtoupper(trim($this->input->post('id_ticket')));
        $data['status'] = 8;
        $data['deskripsi'] = trim($this->input->post('deskripsi'));
        // $data['keterangan_pending'] = trim($this->input->post('keterangan_pending'));
        $this->db->trans_start();

        // $this->db->where('id_ticket', $ticket);
        // $this->db->update('ticket', $data);

        $this->db->insert('tracking', $tracking);

        $this->db->where('id_ticket', $ticket);
        $this->db->update('ticket', $data);
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->session->set_flashdata("msg", "<div class='alert bg-danger' role='alert'>
        	    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
        	    <svg class='glyph stroked empty-message'><use xlink:href='#stroked-empty-message'></use></svg> Data gagal tersimpan.
        	    </div>");
            redirect('myassignment/myassignment_list');
        } else {
            $this->session->set_flashdata("msg", "<div class='alert bg-success' role='alert'>
        	    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
        	    <svg class='glyph stroked empty-message'><use xlink:href='#stroked-empty-message'></use></svg> Data tersimpan.
        	    </div>");
            redirect('myassignment/myassignment_list');
        }
    }

    function approval_requestorlist_adm()
    {
        $data['header'] = "header/header";
        $data['navbar'] = "navbar/navbar";
        $data['sidebar'] = "sidebar/sidebar";
        $data['body'] = "body/approval_requestor_adm";

        $id_user = trim($this->session->userdata('id_user'));

        //notification 

        $sql_listticket = "SELECT COUNT(id_ticket) AS jml_list_ticket FROM ticket WHERE status = 2";
        $row_listticket = $this->db->query($sql_listticket)->row();

        $data['notif_list_ticket'] = $row_listticket->jml_list_ticket;

        $sql_approvalticket = "SELECT COUNT(A.id_ticket) AS jml_approval_ticket FROM ticket A 
        LEFT JOIN sub_kategori B ON B.id_sub_kategori = A.id_sub_kategori 
        LEFT JOIN kategori C ON C.id_kategori = B.id_kategori
        LEFT JOIN karyawan D ON D.nik = A.reported 
        LEFT JOIN departemen E ON E.id_dept = D.id_dept Where E.id_divisi AND status = 1";
        $row_approvalticket = $this->db->query($sql_approvalticket)->row();

        $data['notif_approval'] = $row_approvalticket->jml_approval_ticket;

        $sql_assignmentticket = "SELECT COUNT(id_ticket) AS jml_assignment_ticket FROM ticket A 
        left join teknisi T on T.id_teknisi = A.id_teknisi
        inner join karyawan D on D.nik = T.nik
        where D.nik ='$id_user' AND A.status = 3";
        $row_assignmentticket = $this->db->query($sql_assignmentticket)->row();

        $data['notif_assignment'] = $row_assignmentticket->jml_assignment_ticket;

        //notif pending _adm
        $sql_pending_adm = "SELECT COUNT(id_ticket) AS jml_pending_adm FROM ticket A 
        left join teknisi T on T.id_teknisi = A.id_teknisi
        WHERE A.status IN (6, 7,8)";

        $row_pending_adm = $this->db->query($sql_pending_adm)->row();
        $data['notif_pending_adm'] = $row_pending_adm->jml_pending_adm;

        //end notification
        //load model
        $data_requestor_adm = $this->model_app->dataapproval_requestor_adm();
        $data['dataapproval_requestor_adm'] = $data_requestor_adm;

        $this->load->view('template', $data);
    }

    function terima_selesai($ticket)
    {
        $data['status'] = 9;
        $id_user = trim($this->session->userdata('id_user'));
        $tanggal = $time = date("Y-m-d  H:i:s");

        $tracking['id_ticket'] = $ticket;
        $tracking['tanggal'] = $tanggal;
        $tracking['nama'] = $this->session->userdata('nama_user');
        $tracking['status'] = 'ticket berhasil di tutup';
        // $data['tanggal_proses'] = $tanggal;
        $data['tanggal_solved'] = $tanggal;
        $this->db->trans_start();

        $this->db->where('id_ticket', $ticket);
        $this->db->update('ticket', $data);

        $this->db->insert('tracking', $tracking);

        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {

            redirect('approval/approval_requestorlist');
        } else {

            redirect('approval/approval_requestorlist');
        }
    }

    function terima_selesai_adm($ticket)
    {
        // $id_user = trim($this->session->userdata('id_user'));
        $tanggal = $time = date("Y-m-d  H:i:s");
        $data['status'] = 9;

        $tracking['id_ticket'] = $ticket;
        $tracking['tanggal'] = $tanggal;

        // $data['tanggal_proses'] = $tanggal;
        $data['tanggal_solved'] = $tanggal;

        $this->db->trans_start();

        $this->db->where('id_ticket', $ticket);
        $this->db->update('ticket', $data);

        $this->db->insert('tracking', $tracking);

        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {

            redirect('approval/approval_requestorlist_adm');
        } else {

            redirect('approval/approval_requestorlist_adm');
        }
    }

    function proses($ticket)
    {
        $tanggal = $time = date("Y-m-d  H:i:s");
        $data['status'] = 4;
        // $id_user = trim($this->session->userdata('id_user'));

        $tracking['id_ticket'] = $ticket;
        $tracking['status'] = 'Ticket dikembalikan';
        $tracking['tanggal'] = $tanggal;
        $tracking['nama'] = $this->session->userdata('nama_user');

        $this->db->trans_start();

        $this->db->where('id_ticket', $ticket);
        $this->db->update('ticket', $data);

        $this->db->insert('tracking', $tracking);

        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {

            redirect('approval/approval_requestorlist');
        } else {

            redirect('approval/approval_requestorlist');
        }
    }
    function proses_adm($ticket)
    {
        $id_user = trim($this->session->userdata('id_user'));
        $tanggal = $time = date("Y-m-d  H:i:s");

        $data['status'] = 4;
        $tracking['id_user'] = $id_user;
        // $id_user = trim($this->session->userdata('id_user'));

        $tracking['id_ticket'] = $ticket;
        $tracking['tanggal'] = $tanggal;
        $tracking['status'] = "Ticket dikembalikan";
        // $tracking['deskripsi'] = "";

        $this->db->trans_start();

        $this->db->where('id_ticket', $ticket);
        $this->db->update('ticket', $data);

        $this->db->insert('tracking', $tracking);

        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {

            redirect('approval/approval_requestorlist_adm');
        } else {

            redirect('approval/approval_requestorlist_adm');
        }
    }
    function close_ticket($ticket)
    {
        $tanggal = $time = date("Y-m-d  H:i:s");
        $data['status'] = 10;
        $id_user = trim($this->session->userdata('id_user'));

        $tracking['id_ticket'] = $ticket;
        $tracking['id_user'] = $id_user;
        $tracking['tanggal'] = $tanggal;
        // $tracking['status'] = "Ticket dikembalikan";

        $this->db->trans_start();

        $this->db->where('id_ticket', $ticket);
        $this->db->update('ticket', $data);

        $this->db->insert('tracking', $tracking);

        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {

            redirect('approval/approval_requestorlist');
        } else {

            redirect('approval/approval_requestorlist');
        }
    }

    function close_selesai_adm($ticket)
    {
        $tanggal = $time = date("Y-m-d  H:i:s");
        $data['status'] = 10;
        $id_user = trim($this->session->userdata('id_user'));

        $tracking['id_ticket'] = $ticket;
        $tracking['id_user'] = $id_user;
        $tracking['tanggal'] = $tanggal;
        $this->db->trans_start();

        $this->db->where('id_ticket', $ticket);
        $this->db->update('ticket', $data);

        $this->db->insert('tracking', $tracking);

        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {

            redirect('approval/approval_requestorlist_adm');
        } else {

            redirect('approval/approval_requestorlist_adm');
        }
    }
}
