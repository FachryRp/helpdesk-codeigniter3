<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Departemen extends CI_Controller
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


    function departemen_list()
    {

        $data['header'] = "header/header";
        $data['navbar'] = "navbar/navbar";
        $data['sidebar'] = "sidebar/sidebar";
        $data['body'] = "body/departemen";

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
        //LEFT JOIN bagian_departemen E ON E.id_bagian_dept = D.id_bagian_dept WHERE E.id_dept = '$id_dept' AND status = 1";
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
        WHERE A.status IN (6,7, 8)";

        $row_pending_adm = $this->db->query($sql_pending_adm)->row();
        $data['notif_pending_adm'] = $row_pending_adm->jml_pending_adm;
        //end notification

        $data['link'] = "departemen/hapus";

        $datadepartemen = $this->model_app->datadepartemen();
        $data['datadepartemen'] = $datadepartemen;


        $this->load->view('template', $data);
    }

    function hapus()
    {
        $id = $_POST['id'];

        $this->db->trans_start();

        $this->db->where('id_dept', $id);
        $this->db->delete('departemen');

        $this->db->trans_complete();
    }

    function add()
    {

        $data['header'] = "header/header";
        $data['navbar'] = "navbar/navbar";
        $data['sidebar'] = "sidebar/sidebar";
        $data['body'] = "body/form_departemen";

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
        WHERE A.status IN (6, 7,8)";

        $row_pending_adm = $this->db->query($sql_pending_adm)->row();
        $data['notif_pending_adm'] = $row_pending_adm->jml_pending_adm;
        //end notification

        $data['id_departemen'] = "";
        $data['nama_departemen'] = "";
        $data['dd_divisi'] = $this->model_app->dropdown_divisi();
        $data['id_divisi'] = "";
        $data['url'] = "departemen/save";

        $this->load->view('template', $data);
    }



    function save()
    {

        $nama_dept = strtoupper(trim($this->input->post('nama_dept')));
        $id_divisi = strtoupper(trim($this->input->post('id_divisi')));

        $data['nama_dept'] = $nama_dept;
        $data['id_divisi'] = $id_divisi;

        $this->db->trans_start();

        $this->db->insert('departemen', $data);

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->session->set_flashdata("msg", "<div class='alert bg-danger' role='alert'>
			    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
			    <svg class='glyph stroked empty-message'><use xlink:href='#stroked-empty-message'></use></svg> Data gagal tersimpan.
			    </div>");
            redirect('departemen/departemen_list');
        } else {
            $this->session->set_flashdata("msg", "<div class='alert bg-success' role='alert'>
			    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
			    <svg class='glyph stroked empty-message'><use xlink:href='#stroked-empty-message'></use></svg> Data  tersimpan.
			    </div>");
            redirect('departemen/departemen_list');
        }
    }

    function edit($id)
    {

        $data['header'] = "header/header";
        $data['navbar'] = "navbar/navbar";
        $data['sidebar'] = "sidebar/sidebar";
        $data['body'] = "body/form_departemen";


        // $id_dept = trim($this->session->userdata('id_dept'));
        $id_divisi = trim($this->session->userdata('id_divisi'));
        // $id_user = trim($this->session->userdata('id_user'));

        $id_dept = trim($this->session->userdata('id_dept'));
        $id_user = trim($this->session->userdata('id_user'));

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
        WHERE A.status IN (6, 7, 8)";

        $row_pending_adm = $this->db->query($sql_pending_adm)->row();
        $data['notif_pending_adm'] = $row_pending_adm->jml_pending_adm;
        //end notifikasi

        $sql = "SELECT * FROM departemen WHERE id_dept = '$id'";
        $row = $this->db->query($sql)->row();

        $data['url'] = "departemen/update";

        $data['id_departemen'] = $id;
        $data['nama_departemen'] = $row->nama_dept;
        $data['dd_divisi'] = $this->model_app->dropdown_divisi();
        $data['id_divisi'] = $row->id_divisi;


        $this->load->view('template', $data);
    }

    function update()
    {

        $id_dept = strtoupper(trim($this->input->post('id_dept')));
        $nama_dept = strtoupper(trim($this->input->post('nama_dept')));
        $id_divisi = strtoupper(trim($this->input->post('id_divisi')));
        $data['nama_dept'] = $nama_dept;
        $data['id_divisi'] = $id_divisi;


        $this->db->trans_start();

        $this->db->where('id_dept', $id_dept);
        $this->db->update('departemen', $data);


        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->session->set_flashdata("msg", "<div class='alert bg-danger' role='alert'>
			    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
			    <svg class='glyph stroked empty-message'><use xlink:href='#stroked-empty-message'></use></svg> Data gagal tersimpan.
			    </div>");
            redirect('departemen/departemen_list');
        } else {
            $this->session->set_flashdata("msg", "<div class='alert bg-success' role='alert'>
			    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
			    <svg class='glyph stroked empty-message'><use xlink:href='#stroked-empty-message'></use></svg> Data tersimpan.
			    </div>");
            redirect('departemen/departemen_list');
        }
    }
}
