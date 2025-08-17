<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Main extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('Madmin');

		$this->load->library('cart');

		$params = array('server_key' => 'SB-Mid-server-tKeKFHIcaOdBEHI-9yVZhVb0', 'production' => false);
		$this->load->library('midtrans');
		$this->midtrans->config($params);
		$this->load->helper('url');
	}

	public function submit_rating()
	{
		$product_id = $this->input->post('product_id');// Pastikan user sudah login
		$rating = $this->input->post('rating');
		$pesan = $this->input->post('pesan');
		$name = $this->input->post('name');

		$data = array(
			'idProduk' => $product_id,
			'Rating' => $rating,
			'Pesan' => $pesan,
			'Nama' => $name
		);

		$this->Madmin->save_rating($data);
		redirect('main/detail_produk/' . $product_id); // Redirect kembali ke halaman produk
	}

	public function index()
	{
		$data['produk'] = $this->Madmin->get_produk()->result();
		$data['kategori'] = $this->Madmin->get_all_data('tbl_kategori')->result();
		$this->load->view('home/layout/header', $data);
		$this->load->view('home/layanan');
		$this->load->view('home/home');
		$this->load->view('home/layout/footer');
	}

	public function dashboard()
	{
		$data['produk'] = $this->Madmin->get_produk()->result();
		$data['kategori'] = $this->Madmin->get_all_data('tbl_kategori')->result();
		$this->load->view('home/layout/header', $data);
		$this->load->view('home/dashboard');
		$this->load->view('home/layout/footer');
	}

	public function register()
	{
		$this->load->view('home/layout/header');
		$this->load->view('home/register');
		$this->load->view('home/layout/footer');
	}

	public function save_reg()
	{
		$nama = $this->input->post('nama');
		$email = $this->input->post('email');
		$telpon = $this->input->post('telpon');
		$idKota = $this->input->post('city');
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$alamat = $this->input->post('alamat');

		$dataInput = array('username' => $username, 'password' => $password, 'idKota' => $idKota, 'namaKonsumen' => $nama, 'alamat' => $alamat, 'email' => $email, 'tlpn' => $telpon, 'statusAktif' => 'Y');
		$this->Madmin->insert('tbl_member', $dataInput);
		redirect('main/login');
	}

	public function login()
	{
		$data['kategori'] = $this->Madmin->get_all_data('tbl_kategori')->result();
		$this->load->view('home/layout/header', $data);
		$this->load->view('home/login', $data);
		$this->load->view('home/layout/footer');
	}

	public function login_member()
	{
		$this->load->model('Madmin');
		$u = $this->input->post('username');
		$p = $this->input->post('password');

		$cek = $this->Madmin->cek_login_member($u, $p)->num_rows();
		$result = $this->Madmin->cek_login_member($u, $p)->row_object();

		if ($cek == 1) {
			$data_session = array(
				'idKonsumen' => $result->idKonsumen,
				'idKotaTujuan' => $result->idKota,
				'Member' => $u,
				'status' => 'login'
			);
			$this->session->set_userdata($data_session);
			redirect('main/dashboard');
		} else {
			redirect('main/login');
		}
	}

	public function detail_produk($idProduk)
	{
		$data['produk'] = $this->Madmin->get_by_id('tbl_produk', array('idProduk' => $idProduk))->row_object();
		$data['rating'] = $this->Madmin->getRatingById($idProduk)->result(); // Menggunakan $idProduk sebagai parameter
		$data['kategori'] = $this->Madmin->get_all_data('tbl_kategori')->result();
		$this->load->view('home/layout/header', $data);
		$this->load->view('home/detail_produk', $data);
		$this->load->view('home/layout/footer');
	}


	public function produk_by_kategori($idkat)
	{
		$data['idkat'] = $idkat;
		$data['produk'] = $this->Madmin->get_produk($idkat)->result();
		$data['kategori'] = $this->Madmin->get_all_data('tbl_kategori')->result();
		$this->load->view('home/layout/header', $data);
		$this->load->view('home/home', $data);
		$this->load->view('home/layout/footer');
	}

	public function add_cart($idProduk)
	{
		if (empty($this->session->userdata('idKonsumen'))) {
			echo "<script>alert('Anda harus masuk dulu untuk menambahkan keranjang'); history.back()</script>";
			exit();
		}

		// Ambil data produk berdasarkan idProduk
		$dataWhere = array('idProduk' => $idProduk);
		$produk = $this->Madmin->get_by_id('tbl_produk', $dataWhere)->row_object();

		// Ambil kota penjual
		$kota = $this->Madmin->get_kota_penjual($produk->idToko)->row_object();

		// Set session untuk data produk yang akan dimasukkan ke keranjang
		$this->session->set_userdata('idProduknya', $produk->idProduk);
		$this->session->set_userdata('harganya', $produk->harga);
		$this->session->set_userdata('idKotaAsal', $kota->idKota);
		$this->session->set_userdata('idTokoPenjual', $produk->idToko);

		// Cek apakah produk sudah ada di keranjang
		$is_exist = false;
		foreach ($this->cart->contents() as $item) {
			if ($item['id'] == $produk->idProduk) {
				$is_exist = true;
				break;
			}
		}

		// Jika produk belum ada di keranjang, tambahkan ke keranjang
		if (!$is_exist) {
			$data = array(
				'id' => $produk->idProduk,
				'qty' => 1,
				'price' => $produk->harga,
				'name' => $produk->namaProduk,
				'image' => $produk->foto
			);

			$this->cart->insert($data);
		}

		redirect("main/cart");
	}


	public function cart()
	{
		if (empty($this->session->userdata('idKonsumen'))) {
			echo "<script>alert('Anda harus login dulu untuk add cart');history.back()</script>";
			exit();
		}
		$data['harga_nya'] = $this->session->userdata('harganya');
		$data['id_Produknya'] = $this->session->userdata('idProduknya');
		$data['kota_asal'] = $this->session->userdata('idKotaAsal');
		$data['kota_tujuan'] = $this->session->userdata('idKotaTujuan');

		$data['cartItems'] = $this->cart->contents();
		$data['kategori'] = $this->Madmin->get_all_data('tbl_kategori')->result();
		$data['total'] = $this->cart->total();

		$this->load->view('home/layout/header', $data);
		$this->load->view('home/cart', $data);
		$this->load->view('home/layout/footer');
	}

	public function getProvince()
	{
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => "http://api.rajaongkir.com/starter/province",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_HTTPHEADER => array(
				"key: 510731e7635c49bcdbc4f15659944450"
			),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);
		$data = json_decode($response, true);
		echo "<option value=''>Pilih Provinsi</option>";
		for ($i = 0; $i < count($data['rajaongkir']['results']); $i++) {
			echo "<option value= '" . $data['rajaongkir']['results'][$i]['province_id'] . "'>" . $data['rajaongkir']['results'][$i]['province'] . "</option>";
		}
	}

	public function getCity($province)
	{
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => "http://api.rajaongkir.com/starter/city?province=" . $province,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_HTTPHEADER => array(
				"key: 510731e7635c49bcdbc4f15659944450"
			),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);
		$data = json_decode($response, true);
		echo "<option value=''>Pilih Kota</option>";
		for ($i = 0; $i < count($data['rajaongkir']['results']); $i++) {
			echo "<option value='" . $data['rajaongkir']['results'][$i]['city_id'] . "'>" . $data['rajaongkir']['results'][$i]['city_name'] . "</option>";
		}
	}

	private function generate_resi()
	{
		return 'RESI-' . strtoupper(uniqid());
	}

	public function proses_transaksi()
	{
		try {
			// Mendapatkan data member
			$dataWhere = array('idKonsumen' => $this->session->userdata('idKonsumen'));
			$member = $this->Madmin->get_by_id('tbl_member', $dataWhere)->row_object();

			if (!$member) {
				throw new Exception("Failed to load member data.");
			}

			// Mendapatkan kota asal dan tujuan dari session
			$kota_asal = $this->session->userdata('idKotaAsal');
			$kota_tujuan = $this->session->userdata('idKotaTujuan');
			$id_Produknya = $this->session->userdata('idProduknya');

			if (empty($kota_asal) || empty($kota_tujuan)) {
				throw new Exception("Failed to get shipping cost. Kota asal atau kota tujuan tidak tersedia.");
			}

			// Mendapatkan ongkir menggunakan helper atau fungsi lainnya
			$this->load->helper('toko');
			$ongkir = getOngkir($kota_asal, $kota_tujuan, '1000', 'jne');

			if (empty($ongkir['rajaongkir']['results'][0]['costs'][0]['cost'][0]['value'])) {
				throw new Exception("Failed to get shipping cost.");
			}

			$ongkir_value = $ongkir['rajaongkir']['results'][0]['costs'][0]['cost'][0]['value'];
			$resi = $this->generate_resi();

			// Menyusun data yang akan dimasukkan ke dalam tabel order
			$dataInput = array(
				'idKonsumen' => $member->idKonsumen,
				'idToko' => $this->session->userdata('idTokoPenjual'),
				'idProduk' => $id_Produknya,
				'tglOrder' => date("Y-m-d"),
				'statusOrder' => "Belum Bayar",
				'kurir' => "JNE Oke",
				'ongkir' => $ongkir_value,
			);

			// Menyimpan data order ke dalam database
			$this->Madmin->insert('tbl_order', $dataInput);

			// Mendapatkan ID order yang baru saja disimpan
			$insert_id = $this->db->insert_id();

			// Simpan data history penjualan untuk setiap item dalam keranjang belanja
			foreach ($this->cart->contents() as $item) {
				$dataSale = array(
					'idToko' => $this->session->userdata('idTokoPenjual'),
					'namaProduk' => $item['name'],
					'quantity' => $item['qty'],
					'harga' => $item['price'],
					'total' => $item['subtotal'],
					'tanggalJual' => date("Y-m-d"),
					'resi' => $resi,
				);

				// Simpan data penjualan ke dalam database
				$this->Madmin->save_sale($dataSale);
			}

			// Persiapan data untuk dikirim ke Midtrans
			$transaction_details = array(
				'order_id' => $insert_id,
				'gross_amount' => $ongkir_value + $this->cart->total(),
			);

			// Persiapan item details dari keranjang belanja
			$item_details = [];
			foreach ($this->cart->contents() as $item) {
				$item_details[] = array(
					'id' => $item["id"],
					'price' => $item["price"],
					'quantity' => $item["qty"],
					'name' => $item["name"]
				);
			}

			// Menambahkan detail ongkir ke item details
			$item_details[] = array(
				'id' => "ONGKIR",
				'price' => $ongkir_value,
				'quantity' => 1,
				'name' => "Ongkos Kirim JNE Oke"
			);

			// Persiapan alamat billing dan shipping
			$billing_address = array(
				'first_name' => $member->namaKonsumen,
				'last_name' => "",
				'address' => $member->alamat,
				'city' => $member->alamat, // Ubah sesuai data yang sesuai
				'postal_code' => "",
				'phone' => $member->tlpn,
				'country_code' => 'IDN'
			);

			$shipping_address = array(
				'first_name' => $member->namaKonsumen,
				'last_name' => "",
				'address' => $member->alamat,
				'city' => $member->alamat, // Ubah sesuai data yang sesuai
				'postal_code' => "",
				'phone' => $member->tlpn,
				'country_code' => 'IDN'
			);

			// Persiapan detail customer
			$customer_details = array(
				'first_name' => $member->namaKonsumen,
				'last_name' => "",
				'email' => $member->email,
				'phone' => $member->tlpn,
				'billing_address' => $billing_address,
				'shipping_address' => $shipping_address
			);

			// Konfigurasi token SNAP
			$credit_card['secure'] = true;

			$time = time();
			$custom_expiry = array(
				'start_time' => date("Y-m-d H:i:s O", $time),
				'unit' => 'hour',
				'duration' => 2
			);

			// Data transaksi yang akan disubmit ke Midtrans
			$transaction_data = array(
				'transaction_details' => $transaction_details,
				'item_details' => $item_details,
				'customer_details' => $customer_details,
				'credit_card' => $credit_card,
				'expiry' => $custom_expiry
			);

			// Mendapatkan token SNAP dari Midtrans
			$snapToken = $this->midtrans->getSnapToken($transaction_data);
			echo $snapToken;

		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public function search_resi()
	{
		$resi = $this->input->post('resi');
		$order = $this->Madmin->get_history_by_resi($resi);
		$data['order'] = $order;
		$data['history_penjualans'] = $this->Madmin->get_all_data('tbl_history_penjualan')->result(); // Ambil semua data order untuk ditampilkan di tabel
		$this->load->view('home/layout/header', $data);
		$this->load->view('home/order_history_penjualan', $data);
		$this->load->view('home/layout/footer');
	}

	public function finish()
	{
		// Get the POST data from Midtrans
		$result_data = json_decode($this->input->post('result_data'));

		// Handle based on transaction_status
		if ($result_data->transaction_status == "settlement") {
			// Update order status to 'Dikemas'
			$id = $result_data->order_id;
			$dataUpdate = array('statusOrder' => "Dikemas");
			$this->Madmin->update('tbl_order', $dataUpdate, 'idOrder', $id);

			$idKonsumen = $this->session->userdata('idKonsumen');
			// Mendapatkan data order dari database
			$order = $this->Madmin->get_by_id('tbl_order', array('idOrder' => $id))->row();

			// Redirect to order history after updating status
			redirect('main/order_history');
		} else {
			// Handle other transaction statuses or errors
			redirect('/'); // Redirect to homepage or error page
		}
	}



	public function order_history()
	{
		if (empty($this->session->userdata('idKonsumen'))) {
			redirect('main/login');
		}

		$idKonsumen = $this->session->userdata('idKonsumen');
		$orders = $this->Madmin->get_order_history($idKonsumen);

		// Loop through orders to add shipping cost to total
		foreach ($orders as $order) {
			if (!isset($order->total)) {
				$order->total = 0; // Pastikan properti total ada
			}
			$order->total += $order->ongkir; // Tambahkan ongkir ke total
		}

		$data['orders'] = $orders;
		$data['kategori'] = $this->Madmin->get_all_data('tbl_kategori')->result();
		$data['total'] = $this->cart->total(); // Ini total di keranjang saat ini

		$this->load->view('home/layout/header', $data);
		$this->load->view('home/order_history', $data);
		$this->load->view('home/layout/footer');
	}

	public function order_history_penjualan($idToko)
	{
		if (empty($idToko)) {
			$idToko = $this->session->userdata('idToko');
			if (empty($idToko)) {
				// Redirect or handle the case where idToko is not available
				redirect('main/login'); // For example, redirect to login page
				return;
			}
		}

		$history_penjualans = $this->Madmin->get_history_penjualan($idToko);
		$data['history_penjualans'] = $history_penjualans;

		$this->load->view('home/layout/header', $data);
		$this->load->view('home/order_history_penjualan', $data);
		$this->load->view('home/layout/footer');
	}


	public function delete_cart($rowid)
	{
		$remove = $this->cart->remove($rowid);
		redirect("main/cart");
	}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect('main/login');
	}
}