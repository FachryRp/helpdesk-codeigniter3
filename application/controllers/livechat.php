<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');
class Livechat extends CI_Controller
{
    function get($id)
    {
        $data['header'] = "header/header";
        $data['navbar'] = "navbar/navbar";
        $data['sidebar'] = "sidebar/sidebar";
        $data['body'] = "body/livechat";

        $id_user = trim($this->session->userdata('id_user'));
        $id_ticket = trim($this->session->userdata('id_ticket'));
        $createdat = $time = date("Y-m-d H:i:s");

        //notifikasi
        $sql_listticket = "SELECT COUNT(id_ticket) AS jml_list_ticket FROM ticket WHERE status = 2";
        $row_listticket = $this->db->query($sql_listticket)->row();

        $data['notif_list_ticket'] = $row_listticket->jml_list_ticket;

        //notifikasi assignment
        $sql_assignmentticket = "SELECT COUNT(id_ticket) AS jml_assignment_ticket FROM ticket A 
        left join teknisi T on T.id_teknisi = A.id_teknisi
        inner join tb_pegawai D on D.nik = T.nik
        WHERE D.nik ='$id_user' AND (A.status = 3 OR A.status = 5)";
        $row_assignmentticket = $this->db->query($sql_assignmentticket)->row();

        $data['notif_assignment'] = $row_assignmentticket->jml_assignment_ticket;

        $livechat['id_pesan'] = $id_ticket;
        $livechat['id'] = "";
        $livechat['id_user'] = $id_user;
        $livechat['createdat'] = $createdat;

        $sql = "SELECT A.progress, A.status, D.nama_karyawan, C.id_kategori, A.id_ticket, A.tanggal, A.problem_summary, A.problem_detail, A.keterangan_pending, B.nama_sub_kategori, C.nama_kategori
                FROM ticket A 
                LEFT JOIN sub_kategori B ON B.id_sub_kategori = A.id_sub_kategori
                LEFT JOIN kategori C ON C.id_kategori = B.id_kategori 
                LEFT JOIN karyawan D ON D.nik = A.reported 
                WHERE A.id_ticket = '$id'";
        $row = $this->db->query($sql)->row();

        $data['id_ticket'] = $id;
        $data['url'] = "body/livechat";
        $livechat['id_pesan'] = $id_ticket;

        $livechatquery = "SELECT A.id_pesan, A.id, A.pesan, A.id_user, A.createdat, b.nama_karyawan, C.nama from livechat A
        left JOIN karyawan B ON B.nik = A.id_user
        left JOIN tb_pegawai C ON C.nik = A.id_user
         where id_pesan = '$id' order by createdat asc";
        $userquery = "select * from karyawan where nik = '$id_user'";
        $user = $this->db->query($userquery)->row();
        $data['user'] = $user;

        $livechats = $this->db->query($livechatquery)->result();


        $data['datachat1'] = $livechats;

        $this->load->view('template', $data);
    }
    function save()
    {
        $id_pesan = trim($this->session->userdata('id_pesan'));
        $livechat['id_pesan'] = strtoupper(trim($this->input->post('id_pesan')));
        $livechat['id'] = "";
        $livechat['createdat'] = date("Y-m-d  H:i:s");
        $livechat['pesan'] = $this->input->post('pesan');
        $livechat['id_user'] = trim($this->session->userdata('id_user'));
        $this->db->trans_start();

        $this->db->insert('livechat', $livechat);
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {

            redirect($_SERVER['HTTP_REFERER']);
        } else {
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
}
