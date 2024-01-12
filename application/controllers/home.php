<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{


	function __construct()
	{
		parent::__construct();


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
		$data['body'] = "body/dashboard";

		$id_dept = trim($this->session->userdata('id_dept'));
		$id_user = trim($this->session->userdata('id_user'));
		// $nama_user = trim($this->session->userdata('nama_user'));
		$data['nama_user'] = trim($this->session->userdata('nama_user'));
		$data['level_user'] = trim($this->session->userdata('level'));
		$data['hak_akses'] = trim($this->session->userdata('hak_akses'));

		//notification 

		$sql_listticket = "SELECT COUNT(id_ticket) AS jml_list_ticket FROM ticket WHERE status = 2";
		$row_listticket = $this->db->query($sql_listticket)->row();

		$data['notif_list_ticket'] = $row_listticket->jml_list_ticket;

		// $sql_approvalticket = "SELECT COUNT(A.id_ticket) AS jml_approval_ticket FROM ticket A 
		// LEFT JOIN sub_kategori B ON B.id_sub_kategori = A.id_sub_kategori 
		// LEFT JOIN kategori C ON C.id_kategori = B.id_kategori
		// LEFT JOIN karyawan D ON D.nik = A.reported 
		// LEFT JOIN departemen E ON E.id_dept = D.id_dept WHERE E.id_dept = $id_dept AND status = 1";
		// $row_approvalticket = $this->db->query($sql_approvalticket)->row();

		$sql_approvalticket = "SELECT COUNT(A.id_ticket) AS jml_approval_ticket FROM ticket A 
        LEFT JOIN sub_kategori B ON B.id_sub_kategori = A.id_sub_kategori 
        LEFT JOIN kategori C ON C.id_kategori = B.id_kategori
        LEFT JOIN tb_pegawai P ON P.nik = A.reported where status = 1";
		$row_approvalticket = $this->db->query($sql_approvalticket)->row();

		$data['notif_approval'] = $row_approvalticket->jml_approval_ticket;

		// $sql_assignmentticket = "SELECT COUNT(id_ticket) AS jml_assignment_ticket FROM ticket WHERE status = 3 AND id_teknisi='$id_user'";
		// $row_assignmentticket = $this->db->query($sql_assignmentticket)->row();

		// where D.nik ='$id_user' AND A.status = 3";

		$sql_assignmentticket = "SELECT COUNT(id_ticket) AS jml_assignment_ticket FROM ticket A 
        left join teknisi T on T.id_teknisi = A.id_teknisi
        inner join tb_pegawai D on D.nik = T.nik
        WHERE D.nik ='$id_user' AND (A.status = 3 OR A.status = 5)";
		$row_assignmentticket = $this->db->query($sql_assignmentticket)->row();

		$data['notif_assignment'] = $row_assignmentticket->jml_assignment_ticket;

		//notif pending
		// WHERE A.reported = '$id_user' AND A.status = 6 OR A.status = 8 OR A.status = 7";

		$sql_pending = "SELECT COUNT(id_ticket) AS jml_pending FROM ticket A 
        left join teknisi T on T.id_teknisi = A.id_teknisi
        WHERE A.reported = '$id_user' AND A.status IN (6,7,8)";
		$row_pending = $this->db->query($sql_pending)->row();

		$data['notif_pending'] = $row_pending->jml_pending;

		//notif pending _adm
		$sql_pending_adm = "SELECT COUNT(id_ticket) AS jml_pending_adm FROM ticket A 
        left join teknisi T on T.id_teknisi = A.id_teknisi
        WHERE A.status IN (6,7, 8)";

		$row_pending_adm = $this->db->query($sql_pending_adm)->row();
		$data['notif_pending_adm'] = $row_pending_adm->jml_pending_adm;
		//end notification

		$sql_ticket = "SELECT COUNT(id_ticket) AS jml_ticket FROM ticket";
		$row_ticket = $this->db->query($sql_ticket)->row();

		//Tiket berdasarkan user

		$sql_ticket_user = "SELECT COUNT(id_ticket) AS jml_ticket FROM ticket where reported ='$id_user'";
		$row_ticket_user = $this->db->query($sql_ticket_user)->row();

		$sql_user = "SELECT COUNT(id_user) AS jml_user FROM user";
		$row_user = $this->db->query($sql_user)->row();

		$sql_karyawan = "SELECT COUNT(nik) AS jml_karyawan FROM karyawan";
		$row_karyawan = $this->db->query($sql_karyawan)->row();

		$sql_teknisi = "SELECT COUNT(id_teknisi) AS jml_teknisi FROM teknisi";
		$row_teknisi = $this->db->query($sql_teknisi)->row();

		$sql_ticket_close = "SELECT COUNT(id_ticket) AS jml_ticket_close FROM ticket where status IN (7,10)";
		$row_ticket_close = $this->db->query($sql_ticket_close)->row();

		$sql_ticket_solved = "SELECT COUNT(id_ticket) AS jml_ticket_solved FROM ticket where status IN (6, 9)";
		$row_ticket_solved = $this->db->query($sql_ticket_solved)->row();

		$sql_ticket_process = "SELECT COUNT(id_ticket) AS jml_ticket_process FROM ticket where status = 4";
		$row_ticket_process = $this->db->query($sql_ticket_process)->row();


		$sql_ticket_app_int = "SELECT COUNT(id_ticket) AS jml_ticket_app_int FROM ticket where status = 1";
		$row_ticket_app_int = $this->db->query($sql_ticket_app_int)->row();

		$sql_ticket_app_tek = "SELECT COUNT(id_ticket) AS jml_ticket_app_tek FROM ticket where status = 3";
		$row_ticket_app_tek = $this->db->query($sql_ticket_app_tek)->row();

		//Data ticket User
		$sql_ticket_close_user = "SELECT COUNT(id_ticket) AS jml_ticket_close FROM ticket where status IN (7,10) and reported='$id_user'";
		$row_ticket_close_user = $this->db->query($sql_ticket_close_user)->row();

		$sql_ticket_solved_user = "SELECT COUNT(id_ticket) AS jml_ticket_solved FROM ticket where status IN (6, 9) and reported='$id_user'";
		$row_ticket_solved_user = $this->db->query($sql_ticket_solved_user)->row();

		$sql_ticket_process_user = "SELECT COUNT(id_ticket) AS jml_ticket_process FROM ticket where status = 4 and reported='$id_user'";
		$row_ticket_process_user = $this->db->query($sql_ticket_process_user)->row();


		$sql_ticket_app_int_user = "SELECT COUNT(id_ticket) AS jml_ticket_app_int FROM ticket where status = 1 and reported='$id_user'";
		$row_ticket_app_int_user = $this->db->query($sql_ticket_app_int_user)->row();

		$sql_ticket_app_tek_user = "SELECT COUNT(id_ticket) AS jml_ticket_app_tek FROM ticket where status = 3 and reported='$id_user'";
		$row_ticket_app_tek_user = $this->db->query($sql_ticket_app_tek_user)->row();

		//Data ticket User

		//KEPUASAN USER

		$data['jml_ticket_user'] = $row_ticket_user->jml_ticket;
		$data['jml_ticket'] = $row_ticket->jml_ticket;
		$data['jml_user'] = $row_user->jml_user;
		$data['jml_karyawan'] = $row_karyawan->jml_karyawan;
		$data['jml_teknisi'] = $row_teknisi->jml_teknisi;

		// $precent_ticket_close = $row_ticket_close->jml_ticket_close / $row_ticket->jml_ticket * 100;

		// $precent_ticket_solved = $row_ticket_solved->jml_ticket_solved / $row_ticket->jml_ticket * 100;

		// $precent_ticket_process = $row_ticket_process->jml_ticket_process / $row_ticket->jml_ticket * 100;

		// $precent_ticket_app_int = $row_ticket_app_int->jml_ticket_app_int / $row_ticket->jml_ticket * 100;

		// $precent_ticket_app_tek = $row_ticket_app_tek->jml_ticket_app_tek / $row_ticket->jml_ticket * 100;

		//ticket_process
		if ($row_ticket_process->jml_ticket_process == 0) {
			$data['jml_ticket_process'] = 0;
		} else {
			$data['jml_ticket_process'] = $row_ticket_process->jml_ticket_process / $row_ticket->jml_ticket * 100;
		}
		//ticket_solved
		if ($row_ticket_solved->jml_ticket_solved == 0) {
			$data['jml_ticket_solved'] = 0;
		} else {
			$data['jml_ticket_solved'] = $row_ticket_solved->jml_ticket_solved / $row_ticket->jml_ticket * 100;
		}
		// ticket_Waiting Approval Internal
		if ($row_ticket_app_int->jml_ticket_app_int == 0) {
			$data['jml_ticket_app_int'] = 0;
		} else {
			$data['jml_ticket_app_int'] = $row_ticket_app_int->jml_ticket_app_int / $row_ticket->jml_ticket * 100;
		}
		// Ticket_Waiting Approval Technition
		if ($row_ticket_app_tek->jml_ticket_app_tek == 0) {
			$data['jml_ticket_app_tek'] = 0;
		} else {
			$data['jml_ticket_app_tek'] = $row_ticket_app_tek->jml_ticket_app_tek / $row_ticket->jml_ticket * 100;
		}
		// Ticket_Closed
		if ($row_ticket_close->jml_ticket_close == 0) {
			$data['jml_ticket_close'] = 0;
		} else {
			$data['jml_ticket_close'] = $row_ticket_close->jml_ticket_close / $row_ticket->jml_ticket * 100;
		}

		//Percent tiket user

		//ticket_process_user
		if ($row_ticket_process_user->jml_ticket_process == 0) {
			$data['jml_ticket_process_user'] = 0;
		} else {
			$data['jml_ticket_process_user'] = $row_ticket_process_user->jml_ticket_process / $row_ticket_user->jml_ticket * 100;
		}
		//ticket_solved_user
		if ($row_ticket_solved_user->jml_ticket_solved == 0) {
			$data['jml_ticket_solved_user'] = 0;
		} else {
			$data['jml_ticket_solved_user'] = $row_ticket_solved_user->jml_ticket_solved / $row_ticket_user->jml_ticket * 100;
		}
		// ticket_Waiting Approval Internal_user
		if ($row_ticket_app_int_user->jml_ticket_app_int == 0) {
			$data['jml_ticket_app_int_user'] = 0;
		} else {
			$data['jml_ticket_app_int_user'] = $row_ticket_app_int_user->jml_ticket_app_int / $row_ticket_user->jml_ticket * 100;
		}
		// Ticket_Waiting Approval Technition
		if ($row_ticket_app_tek_user->jml_ticket_app_tek == 0) {
			$data['jml_ticket_app_tek_user'] = 0;
		} else {
			$data['jml_ticket_app_tek_user'] = $row_ticket_app_tek_user->jml_ticket_app_tek / $row_ticket_user->jml_ticket * 100;
		}
		// Ticket_Closed_user
		if ($row_ticket_close_user->jml_ticket_close == 0) {
			$data['jml_ticket_close_user'] = 0;
		} else {
			$data['jml_ticket_close_user'] = $row_ticket_close_user->jml_ticket_close / $row_ticket_user->jml_ticket * 100;
		}

		// $precent_ticket_close_user = $row_ticket_close_user->jml_ticket_close / $row_ticket_user->jml_ticket * 100;

		// $precent_ticket_solved_user = $row_ticket_solved_user->jml_ticket_solved / $row_ticket_user->jml_ticket * 100;

		// $precent_ticket_process_user = $row_ticket_process_user->jml_ticket_process / $row_ticket_user->jml_ticket * 100;

		// $precent_ticket_app_int_user = $row_ticket_app_int_user->jml_ticket_app_int / $row_ticket_user->jml_ticket * 100;

		// $precent_ticket_app_tek_user = $row_ticket_app_tek_user->jml_ticket_app_tek / $row_ticket_user->jml_ticket * 100;

		//percent tiket user


		// $data['jml_ticket_close'] = $precent_ticket_close;
		// $data['jml_ticket_solved'] = $precent_ticket_solved;
		// $data['jml_ticket_process'] = $precent_ticket_process;
		// $data['jml_ticket_app_int'] = $precent_ticket_app_int;
		// $data['jml_ticket_app_tek'] = $precent_ticket_app_tek;

		// $data['jml_ticket_close_user'] = $precent_ticket_close_user;
		// $data['jml_ticket_solved_user'] = $precent_ticket_solved_user;
		// $data['jml_ticket_process_user'] = $precent_ticket_process_user;
		// $data['jml_ticket_app_int_user'] = $precent_ticket_app_int_user;
		// $data['jml_ticket_app_tek_user'] = $precent_ticket_app_tek_user;


		$precent_ticket_app_tek = $row_ticket_app_tek->jml_ticket_app_tek / $row_ticket->jml_ticket * 100;


		$sql_feedback = "SELECT COUNT(id_feedback) AS jml_feedback FROM history_feedback";
		$row_feedback = $this->db->query($sql_feedback)->row();

		$sql_feedback_positiv = "SELECT COUNT(id_feedback) AS jml_feedback_positiv FROM history_feedback WHERE feedback =1";
		$row_feedback_positiv = $this->db->query($sql_feedback_positiv)->row();

		$sql_feedback_negativ = "SELECT COUNT(id_feedback) AS jml_feedback_negativ FROM history_feedback WHERE feedback =0";
		$row_feedback_negativ = $this->db->query($sql_feedback_negativ)->row();

		if ($row_feedback_positiv->jml_feedback_positiv == 0) {
			$data['jml_feedback_positiv'] = 0;
		} else {
			$data['jml_feedback_positiv'] = $row_feedback_positiv->jml_feedback_positiv / $row_feedback->jml_feedback * 100;
		}



		if ($row_feedback_negativ->jml_feedback_negativ == 0) {
			$data['jml_feedback_negativ'] = 0;
		} else {
			$data['jml_feedback_negativ'] = $row_feedback_negativ->jml_feedback_negativ / $row_feedback->jml_feedback * 100;
		}


		$this->load->view('template', $data);
	}
}
