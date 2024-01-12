<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');
class Myassignment extends CI_Controller
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


    function myassignment_list()
    {

        $data['header'] = "header/header";
        $data['navbar'] = "navbar/navbar";
        $data['sidebar'] = "sidebar/sidebar";
        $data['body'] = "body/myassignment";

        $id_dept = trim($this->session->userdata('id_dept'));
        $id_user = trim($this->session->userdata('id_user'));
        // $id_teknisi = trim($this->session->userdata('id_teknisi'));

        //notification 

        $sql_listticket = "SELECT COUNT(id_ticket) AS jml_list_ticket FROM ticket WHERE status = 2";
        $row_listticket = $this->db->query($sql_listticket)->row();

        $data['notif_list_ticket'] = $row_listticket->jml_list_ticket;

        $sql_approvalticket = "SELECT COUNT(A.id_ticket) AS jml_approval_ticket FROM ticket A 
        LEFT JOIN sub_kategori B ON B.id_sub_kategori = A.id_sub_kategori 
        LEFT JOIN kategori C ON C.id_kategori = B.id_kategori
        LEFT JOIN tb_pegawai P ON P.nik = A.reported where status = 1";
        $row_approvalticket = $this->db->query($sql_approvalticket)->row();

        $data['notif_approval'] = $row_approvalticket->jml_approval_ticket;

        // backupan kalo ngebaca status 3 atau menunggu approval
        // where D.nik ='$id_user' AND A.status = 3";

        $sql_assignmentticket = "SELECT COUNT(id_ticket) AS jml_assignment_ticket FROM ticket A 
        left join teknisi T on T.id_teknisi = A.id_teknisi
        inner join tb_pegawai D on D.nik = T.nik
        WHERE D.nik ='$id_user' AND (A.status = 3 OR A.status = 5)";
        $row_assignmentticket = $this->db->query($sql_assignmentticket)->row();

        $data['notif_assignment'] = $row_assignmentticket->jml_assignment_ticket;

        //notif pending _adm
        $sql_pending_adm = "SELECT COUNT(id_ticket) AS jml_pending_adm FROM ticket A 
        left join teknisi T on T.id_teknisi = A.id_teknisi
        WHERE A.status IN (6,7, 8)";

        $row_pending_adm = $this->db->query($sql_pending_adm)->row();
        $data['notif_pending_adm'] = $row_pending_adm->jml_pending_adm;

        //end notification

        $datamyassignment = $this->model_app->datamyassignment($id_user);
        $data['datamyassignment'] = $datamyassignment;

        $this->load->view('template', $data);
    }


    function terima($ticket)
    {

        $id_user = trim($this->session->userdata('id_user'));
        $tanggal = $time = date("Y-m-d  H:i:s");

        $tracking['id_ticket'] = $ticket;
        $tracking['tanggal'] = $tanggal;
        $tracking['status'] = "Diproses oleh teknisi";
        $tracking['deskripsi'] = "";
        $tracking['id_user'] = $id_user;
        $tracking['nama'] = $this->session->userdata('nama_user');

        $data['status'] = 4;
        $data['tanggal_proses'] = $tanggal;

        $this->db->trans_start();

        $this->db->where('id_ticket', $ticket);
        $this->db->update('ticket', $data);

        $this->db->insert('tracking', $tracking);

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {

            redirect('myassignment/myassignment_list');
        } else {

            redirect('myassignment/myassignment_list');
        }
    }
    function terima_req($ticket)
    {

        $id_user = trim($this->session->userdata('id_user'));
        $tanggal = $time = date("Y-m-d  H:i:s");

        $tracking['id_ticket'] = $ticket;
        $tracking['tanggal'] = $tanggal;
        $tracking['status'] = "Diproses oleh teknisi";
        $tracking['deskripsi'] = "";
        $tracking['id_user'] = $id_user;

        $data['status'] = 4;
        $data['tanggal_proses'] = $tanggal;
        $data['keterangan_pending'] = '';
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
    function terima_adm($ticket)
    {

        $id_user = trim($this->session->userdata('id_user'));
        $tanggal = $time = date("Y-m-d  H:i:s");

        $tracking['id_ticket'] = $ticket;
        $tracking['tanggal'] = $tanggal;
        $tracking['status'] = "Diproses oleh teknisi";
        $tracking['deskripsi'] = "";
        $tracking['id_user'] = $id_user;

        $data['status'] = 4;
        $data['tanggal_proses'] = $tanggal;

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

    function pending($ticket)
    {
        $data['status'] = 5;

        $id_user = trim($this->session->userdata('id_user'));
        $progress = trim($this->session->userdata('progress'));
        $tanggal = $time = date("Y-m-d  H:i:s");

        $tracking['id_ticket'] = $ticket;
        $tracking['tanggal'] = $tanggal;
        $tracking['status'] = "Pending oleh teknisi" . $progress;
        $tracking['id_user'] = $id_user;

        $this->db->trans_start();

        $this->db->where('id_ticket', $ticket);
        $this->db->update('ticket', $data);

        $this->db->insert('tracking', $tracking);

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {

            redirect('myassignment/formpending');
        } else {

            redirect('approval/approval_requestorlist');
        }
    }
    function pending_adm($ticket)
    {
        $data['status'] = 5;

        $id_user = trim($this->session->userdata('id_user'));
        $tanggal = $time = date("Y-m-d  H:i:s");

        $tracking['id_ticket'] = $ticket;
        $tracking['tanggal'] = $tanggal;
        $tracking['status'] = "Pending oleh teknisi";
        $tracking['deskripsi'] = "";

        $tracking['id_user'] = $id_user;

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

    function ticket_detail($id)
    {

        $data['header'] = "header/header";
        $data['navbar'] = "navbar/navbar";
        $data['sidebar'] = "sidebar/sidebar";
        $data['body'] = "body/up_progress";

        $id_dept = trim($this->session->userdata('id_dept'));
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
        inner join tb_pegawai D on D.nik = T.nik
        WHERE D.nik ='$id_user' AND (A.status = 3 OR A.status = 5)";
        $row_assignmentticket = $this->db->query($sql_assignmentticket)->row();

        $data['notif_assignment'] = $row_assignmentticket->jml_assignment_ticket;

        //notif pending _adm
        $sql_pending_adm = "SELECT COUNT(id_ticket) AS jml_pending_adm FROM ticket A 
        left join teknisi T on T.id_teknisi = A.id_teknisi
        WHERE A.status IN (6, 7, 8)";

        $row_pending_adm = $this->db->query($sql_pending_adm)->row();
        $data['notif_pending_adm'] = $row_pending_adm->jml_pending_adm;

        //end notification

        $sql = "SELECT A.progress, A.status, D.nama_karyawan, C.id_kategori, A.id_ticket, A.tanggal, A.problem_summary, A.problem_detail, B.nama_sub_kategori, C.nama_kategori, E.nama
                FROM ticket A 
                LEFT JOIN sub_kategori B ON B.id_sub_kategori = A.id_sub_kategori
                LEFT JOIN kategori C ON C.id_kategori = B.id_kategori 
                LEFT JOIN karyawan D ON D.nik = A.reported 
                LEFT JOIN tb_pegawai E ON E.nik = A.reported
                WHERE A.id_ticket = '$id'";

        $row = $this->db->query($sql)->row();

        $id_kategori = $row->id_kategori;


        $data['url'] = "Myassignment/up_progress";

        $data['dd_teknisi'] = $this->model_app->dropdown_teknisi($id_kategori);
        $data['id_teknisi'] = "";

        $data['id_ticket'] = $id;
        $data['progress'] = $row->progress;
        $data['tanggal'] = $row->tanggal;
        $data['nama_sub_kategori'] = $row->nama_sub_kategori;
        $data['nama_kategori'] = $row->nama_kategori;
        $data['reported1'] = $row->nama_karyawan;
        $data['reported'] = $row->nama;
        $data['problem_summary'] = $row->problem_summary;
        $data['problem_detail'] = $row->problem_detail;
        $data['status'] = $row->status;


        //TRACKING TICKET

        $data['nama_teknisi'] = $row->nama_teknisi;
        $data['tanggal_proses'] = $row->tanggal_proses;
        $data['tanggal_solved'] = $row->tanggal_solved;

        $data_trackingticket = $this->model_app->data_trackingticket($id);
        $data['data_trackingticket'] = $data_trackingticket;

        $this->load->view('template', $data);
    }

    function formpending($id)
    {
        $data['header'] = "header/header";
        $data['navbar'] = "navbar/navbar";
        $data['sidebar'] = "sidebar/sidebar";
        $data['body'] = "body/form_pending";



        $id_user = trim($this->session->userdata('id_user'));
        $tanggal = $time = date("Y-m-d  H:i:s");

        $tracking['tanggal'] = $tanggal;
        $tracking['id_user'] = $id_user;

        //notifikasi assignment
        $sql_assignmentticket = "SELECT COUNT(id_ticket) AS jml_assignment_ticket FROM ticket A 
        left join teknisi T on T.id_teknisi = A.id_teknisi
        inner join tb_pegawai D on D.nik = T.nik
        WHERE D.nik ='$id_user' AND (A.status = 3 OR A.status = 5)";
        $row_assignmentticket = $this->db->query($sql_assignmentticket)->row();

        $data['notif_assignment'] = $row_assignmentticket->jml_assignment_ticket;

        $sql = "SELECT A.progress, A.status, D.nama_karyawan, C.id_kategori, A.id_ticket, A.tanggal, A.problem_summary, A.problem_detail, A.keterangan_pending, B.nama_sub_kategori, C.nama_kategori
                FROM ticket A 
                LEFT JOIN sub_kategori B ON B.id_sub_kategori = A.id_sub_kategori
                LEFT JOIN kategori C ON C.id_kategori = B.id_kategori 
                LEFT JOIN karyawan D ON D.nik = A.reported 
                WHERE A.id_ticket = '$id'";

        $row = $this->db->query($sql)->row();
        $data['id_ticket'] = $id;
        $data['url'] = "body/form_pending";
        $data['reported'] = $row->nama;

        $this->load->view('template', $data);
    }

    function up_progress()
    {

        $id_user = trim($this->session->userdata('id_user'));
        $tanggal = $time = date("Y-m-d  H:i:s");

        $ticket = strtoupper(trim($this->input->post('id_ticket')));

        $progress = strtoupper(trim($this->input->post('progress')));
        $tambahan = $this->input->post('tambahan');

        switch ($progress) {
            case 100:
                if ($tambahan == 'selesai') {
                    $data['status'] = 6;
                    $data['tanggal_solved'] = $tanggal;
                } else {
                    $data['status'] = 7;
                }
                break;
            default:
                $data['status'] = 4;
        }

        $deskripsi_progress = trim($this->input->post('deskripsi_progress'));
        //tidak terpakai--------------
        // $data['id_ticket'] = $ticket;
        // $data['tanggal'] = $tanggal;
        // $data['status'] = "Up Progress To " . $progress . " %";
        // $data['deskripsi'] = 'testing';
        // $data['id_user'] = $id_user;
        // $data['progress'] = $progress;
        // $data['problem_summary'] = $row->problem_summary;
        // $data['problem_detail'] = $row->problem_detail;
        // ------------------------------
        $this->db->trans_start();

        // Update Ticket
        $data['deskripsi'] = $deskripsi_progress;
        $data['progress'] = $progress;
        // $data['progress'] = $tambahan;
        // $data['tanggal'] = $tanggal;
        $data['tanggal_proses'] = $tanggal;

        $this->db->where('id_ticket', $ticket);
        $this->db->update('ticket', $data);
        // End Update Ticket

        // Simpan Tracking
        $tracking['id_ticket'] = $ticket;
        $tracking['tanggal'] = $tanggal;
        $tracking['status'] = "Up Progress To " . $progress . " %";
        // $tracking['status'] = "Up Progress To " . $tambahan . " %";
        $tracking['deskripsi'] = $deskripsi_progress;
        $tracking['id_user'] = $id_user;
        $tracking['nama'] = $this->session->userdata('nama_user');
        $this->db->insert('tracking', $tracking);
        // End Simpan Tracking

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {

            redirect('myassignment/myassignment_list');
        } else {

            redirect('myassignment/myassignment_list');
        }
    }
}
