<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Karyawan extends CI_Controller
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


	function karyawan_list()
	{

		$data['header'] = "header/header";
		$data['navbar'] = "navbar/navbar";
		$data['sidebar'] = "sidebar/sidebar";
		$data['body'] = "body/karyawan";


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
        WHERE A.status IN (6,7, 8)";

		$row_pending_adm = $this->db->query($sql_pending_adm)->row();
		$data['notif_pending_adm'] = $row_pending_adm->jml_pending_adm;
		//end notification

		$data['link'] = "karyawan/hapus";

		// $datakaryawan = $this->model_app->datakaryawan();
		// $data['datakaryawan'] = $datakaryawan;
		$datakaryawan1 = $this->model_app->datakaryawan1();
		$data['datakaryawan1'] = $datakaryawan1;

		$this->load->view('template', $data);
	}

	function hapus()
	{
		$id = $_POST['id'];

		$this->db->trans_start();

		$this->db->where('nik', $id);
		$this->db->delete('karyawan');

		$this->db->trans_complete();
	}

	function add()
	{

		$data['header'] = "header/header";
		$data['navbar'] = "navbar/navbar";
		$data['sidebar'] = "sidebar/sidebar";
		$data['body'] = "body/form_karyawan";

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
        WHERE A.status IN (6,7, 8)";

		$row_pending_adm = $this->db->query($sql_pending_adm)->row();
		$data['notif_pending_adm'] = $row_pending_adm->jml_pending_adm;
		//end notification

		$data['nik'] = "";
		$data['nama'] = "";
		$data['alamat'] = "";


		$data['dd_jk'] = $this->model_app->dropdown_jk();
		$data['id_jk'] = "";

		$data['dd_jabatan'] = $this->model_app->dropdown_jabatan();
		$data['id_jabatan'] = "";

		//$data['dd_departemen'] = $this->model_app->dropdown_departemen();
		//$data['id_departemen'] = $row->id_dept;
		//$data['dd_departemen'] = $this->model_app->get_departemen();
		//$data['id_departemen'] = "";

		//$data['dd_divisi'] = $this->model_app->dropdown_departemen();
		//$data['id_divisi'] = "";

		$data['dd_divisi'] = $this->model_app->dropdown_divisi();
		$data['id_divisi'] = "";

		//$postData = $this->input->post();
		//$dataD = $this->model_app->get_departemen($postData);
		//echo json_encode($dataD);

		$data['url'] = "karyawan/save";

		$data['flag'] = "add";

		$this->load->view('template', $data);
	}

	function save()
	{

		$getkodekaryawan = $this->model_app->getkodekaryawan();

		$nik = $getkodekaryawan;

		$nama = strtoupper(trim($this->input->post('nama')));
		$jk = strtoupper(trim($this->input->post('id_jk')));
		$alamat = strtoupper(trim($this->input->post('alamat')));
		$id_divisi = strtoupper(trim($this->input->post('id_divisi')));
		$id_departemen = strtoupper(trim($this->input->post('id_departemen')));
		$id_jabatan = strtoupper(trim($this->input->post('id_jabatan')));

		$data['nik'] = $nik;
		$data['nama'] = $nama;
		$data['jk'] = $jk;
		$data['alamat'] = $alamat;
		$data['id_divisi'] = $id_divisi;
		$data['id_dept'] = $id_departemen;
		$data['id_jabatan'] = $id_jabatan;

		$this->db->trans_start();

		$this->db->insert('karyawan', $data);

		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->session->set_flashdata("msg", "<div class='alert bg-danger' role='alert'>
			    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
			    <svg class='glyph stroked empty-message'><use xlink:href='#stroked-empty-message'></use></svg> Data gagal tersimpan.
			    </div>");
			redirect('karyawan/karyawan_list');
		} else {
			$this->session->set_flashdata("msg", "<div class='alert bg-success' role='alert'>
			    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
			    <svg class='glyph stroked empty-message'><use xlink:href='#stroked-empty-message'></use></svg> Data tersimpan.
			    </div>");
			redirect('karyawan/karyawan_list');
		}
	}

	function edit($id)
	{

		$data['header'] = "header/header";
		$data['navbar'] = "navbar/navbar";
		$data['sidebar'] = "sidebar/sidebar";
		$data['body'] = "body/form_karyawan";

		//$sql = "SELECT * FROM karyawan A LEFT JOIN jabatan B ON B.id_jabatan = A.id_jabatan
		//LEFT JOIN bagian_departemen C ON C.id_bagian_dept = A.id_bagian_dept
		//LEFT JOIN departemen D ON D.id_dept = C.id_dept WHERE A.nik = '$id'";
		//$row = $this->db->query($sql)->row();
		$sql = "SELECT * FROM karyawan A LEFT JOIN jabatan B ON B.id_jabatan = A.id_jabatan
                                               LEFT JOIN departemen C ON C.id_dept = A.id_dept
                                               INNER JOIN divisi D ON D.id_divisi = C.id_divisi WHERE A.nik = '$id'";
		$row = $this->db->query($sql)->row();

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

		$data['url'] = "karyawan/update";

		$data['nik'] = $id;
		$data['nama'] = $row->nama;
		$data['alamat'] = $row->alamat;

		$data['dd_jk'] = $this->model_app->dropdown_jk();
		$data['id_jk'] = $row->jk;

		$data['dd_jabatan'] = $this->model_app->dropdown_jabatan();
		$data['id_jabatan'] = $row->id_jabatan;

		$data['dd_divisi'] = $this->model_app->dropdown_divisi();
		// $data['id_divisi'] = "";
		$data['id_divisi'] = $row->id_divisi;

		//$data['dd_bagian_departemen'] = $this->model_app->dropdown_bagian_departemen($row->id_dept);
		//$data['id_bagian_departemen'] = $row->id_bagian_dept;

		//$data['dd_departemen'] = $this->model_app->dropdown_departemen($row->id_divisi);
		//$data['id_departemen'] = $row->id_dept;

		$data['flag'] = "edit";

		$this->load->view('template', $data);
	}

	function update()
	{

		$nik = strtoupper(trim($this->input->post('nik')));

		$nama = strtoupper(trim($this->input->post('nama')));
		$jk = strtoupper(trim($this->input->post('id_jk')));
		$alamat = strtoupper(trim($this->input->post('alamat')));
		$id_divisi = strtoupper(trim($this->input->post('id_divisi')));
		$id_dept = strtoupper(trim($this->input->post('id_departemen')));
		$id_jabatan = strtoupper(trim($this->input->post('id_jabatan')));


		$data['nama'] = $nama;
		$data['jk'] = $jk;
		$data['alamat'] = $alamat;
		$data['id_divisi'] = $id_divisi;
		$data['id_dept'] = $id_dept;
		$data['id_jabatan'] = $id_jabatan;

		$this->db->trans_start();

		$this->db->where('nik', $nik);
		$this->db->update('karyawan', $data);

		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->session->set_flashdata("msg", "<div class='alert bg-danger' role='alert'>
			    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
			    <svg class='glyph stroked empty-message'><use xlink:href='#stroked-empty-message'></use></svg> Data gagal tersimpan.
			    </div>");
			redirect('karyawan/karyawan_list');
		} else {
			$this->session->set_flashdata("msg", "<div class='alert bg-success' role='alert'>
			    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
			    <svg class='glyph stroked empty-message'><use xlink:href='#stroked-empty-message'></use></svg> Data tersimpan.
			    </div>");
			redirect('karyawan/karyawan_list');
		}
	}
	function get_div()
	{

		$this->load->model('model_app');

		// get cities 
		$data['divisi'] = $this->Main_model->get_divisi();

		// load view 
		$this->load->view('template', $data);
	}
	public function get_dept()
	{
		// POST data 
		$postData = $this->input->post();

		// load model 
		$this->load->model('model_app');

		// get data 
		$data = $this->Main_model->get_dept($postData);
		echo json_encode($data);
	}
}
