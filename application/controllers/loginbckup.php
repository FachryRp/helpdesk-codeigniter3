<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('model_app');
	}


	function index()
	{
		$data = "";

		$this->load->view('login', $data);
	}


	function login_akses()
	{

		$username = trim($this->input->post('username'));
		$password = md5(trim($this->input->post('password')));

		$akses = $this->db->query("select A.username, B.nama, A.level, B.id_jabatan, C.id_dept FROM user A 
		LEFT JOIN karyawan B ON B.nik = A.username
        LEFT JOIN departemen C ON C.id_dept = B.id_dept
	 WHERE A.username = '$username' AND A.password = '$password'");

		if ($akses->num_rows() == 1) {

			foreach ($akses->result_array() as $data) {

				$session['id_user'] = $data['username'];
				$session['nama'] = $data['nama'];
				$session['level'] = $data['level'];
				$session['id_jabatan'] = $data['id_jabatan'];
				$session['id_dept'] = $data['id_dept'];

				$this->session->set_userdata($session);
				redirect('home');
			}
		} else {
			$this->session->set_flashdata("msg", "<div class='alert bg-danger' role='alert'>
			    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
			    <svg class='glyph stroked empty-message'><use xlink:href='#stroked-empty-message'></use></svg> username / Password salah.
			    </div>");
			redirect('login');
		}
	}

	function login_akses_2()
	{

		$username = trim($this->input->post('id_user'));
		// $password = md5(trim($this->input->post('password')));
		$password = sha1(md5(sha1($this->input->post['password']) + ('Tr1@5M1TR4')));
		$akses =


			// 	$akses = $this->db->query("select A.id_user, B.nama_user, A.level, B.hak_akses, C.id_dept FROM tb_user A 
			// 	LEFT JOIN tb_pegawai B ON B.nik = A.id_user
			//     LEFT JOIN departemen C ON C.id_dept = B.id_dept
			//  WHERE A.id_user = '$username' AND A.password = '$password'");

			// 	$akses = $this->db->query(" select A.id_user, B.nama, A.hak_akses FROM tb_user A 
			// LEFT JOIN tb_pegawai B ON B.nik = A.id_user
			// WHERE A.id_user = '$username' AND A.password = '$password'");

			$akses = $this->db->query(" select A.id_user, A.hak_akses, A.password, A.nama_user FROM tb_user A 
		LEFT JOIN tb_pegawai B ON B.nik = A.id_user
	 	WHERE A.id_user = '$username' AND A.password = '$password'");



		if ($akses->num_rows() == 1) {

			foreach ($akses->result_array() as $data) {

				// $session['id_user'] = $data['id_user'];
				// $session['nama'] = $data['nama'];
				// $session['level'] = $data['level'];
				// $session['id_jabatan'] = $data['id_jabatan'];
				// $session['id_dept'] = $data['id_dept'];

				$session['id_user'] = $data['id_user'];
				$session['nama'] = $data['nama'];
				$session['hak_akses'] = $data['hak_akses'];
				$session['nama_user'] = $data['nama_user'];

				$this->session->set_userdata($session);
				redirect('home');
			}
		} else {
			$this->session->set_flashdata("msg", "<div class='alert bg-danger' role='alert'>
			    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
			    <svg class='glyph stroked empty-message'><use xlink:href='#stroked-empty-message'></use></svg> username / Password salah.
			    </div>");
			redirect('login');
		}
	}

	function login_akses_3()
	{
		$url = 'https://hris.triasmitra.com/restric/login_api.php'; // Ganti dengan URL login Anda
		$post_data = [
			'nik' => trim($this->input->post('nik')),
			'password' => trim($this->input->post('password')),
			// 'password' => sha1(md5(sha1($_POST['password']) + ('Tr1@5M1TR4')))
		];

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		$response = curl_exec($ch);

		curl_close($ch);
		if (curl_errno($ch)) {
			// Handle cURL error
			echo 'Curl error: ' . curl_error($ch);
			curl_close($ch);
			return;
		}

		// Handle the response
		$data = json_decode($response, true);

		if ($data && isset($data['success']) && $data['success']) {
			// Login berhasil
			$session['nik'] = $data['nik'];
			$session['nama'] = $data['nama'];
			$session['hak_akses'] = $data['hak_akses'];

			$this->session->set_userdata($session);
			redirect('home');
		} else {
			// Login gagal
			$this->session->set_flashdata("msg", "<div class='alert bg-danger' role='alert'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <svg class='glyph stroked empty-message'><use xlink:href='#stroked-empty-message'></use></svg> username / Password salah.
            </div>");
			redirect('login');
		}
	}
	public function logout()
	{

		$this->session->sess_destroy();

		redirect('login');
	}
}
