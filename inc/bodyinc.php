<?php 
	
	if(isset($_GET['msg']) && $_GET['msg']=='add') 
		echo "onload=\"MM_popupMsg('Maklumat telah berjaya ditambah.')\""; 
	if(isset($_GET['msg']) && $_GET['msg']=='edit') 
		echo "onload=\"MM_popupMsg('Maklumat telah berjaya dikemaskini.')\"";
	else if(isset($_GET['msg']) && $_GET['msg']=='del') 
		echo "onload=\"MM_popupMsg('Maklumat telah berjaya dipadam.')\""; 
	else if(isset($_GET['msg']) && $_GET['msg']=='send') 
		echo "onload=\"MM_popupMsg('Maklumat telah berjaya dihantar.')\""; 
	else if(isset($_GET['msg']) && $_GET['msg']=='error') 
		echo "onload=\"MM_popupMsg('Maklumat tidak diproses. Sila cuba sekali lagi.')\""; 
		
	//error delete
	if((isset($_GET['del']) && $_GET['del']=='1')) 
		echo "onload=\"MM_popupMsg('Anda tiada akses untuk memadam data ini.')\""; 
		
	//email kata laluan
	if((isset($_GET['ef']) && $_GET['ef']=='1')) 
		echo "onload=\"MM_popupMsg('Kata Laluan telah dihantar ke email rasmi ISN.')\""; 
	else if((isset($_GET['ef']) && $_GET['ef']=='2')) 
		echo "onload=\"MM_popupMsg('Email yang dinyatakan tidak dikenalpasti. Sila cuba sekali lagi')\"";
	else if((isset($_GET['ef']) && $_GET['ef']=='3')) 
		echo "onload=\"MM_popupMsg('Kata Laluan tidak dapat disemak dalam tempoh 2 minggu yang ditetapkan daripada tarikh semakkan kata laluan sebelum ini.')\"";
		
	//error staf ID
	if((isset($_GET['e']) && $_GET['e']=='1')) 
		echo "onload=\"MM_popupMsg('Maklumat Pengguna tidak didaftarkan kerana berlaku pertindihan maklumat sedia ada. Sila semak No. Fail Staf (Staf ID) yang dimasukkan')\"";
	else if((isset($_GET['e']) && $_GET['e']=='2')) 
		echo "onload=\"MM_popupMsg('No. Fail Staf (Staf ID) tidak wujud. Sila cuba sekali lagi')\"";
	else if((isset($_GET['e']) && $_GET['e']=='3')) 
		echo "onload=\"MM_popupMsg('Maklumat Staf tidak aktif. Maklumat tidak dikemaskini.')\"";
	else if((isset($_GET['e']) && $_GET['e']=='4')) 
		echo "onload=\"MM_popupMsg('Berlaku pertindihan maklumat sedia ada. Maklumat tidak dikemaskini.')\"";
			
	//error login
	if((isset($_GET['e']) && $_GET['e']=='login')) 
		echo "onload=\"MM_popupMsg('Nama Pengguna dan Kata Laluan tidak dapat dikenalpasti. Sila cuba sekali lagi.')\""; 
	if((isset($_GET['e']) && $_GET['e']=='logout')) 
		echo "onload=\"MM_popupMsg('Sila buat pendaftaran masuk terlebih dahulu.')\""; 
		
	//error penukaran password
	if((isset($_GET['msg']) && $_GET['msg']=='passs')) 
		echo "onload=\"MM_popupMsg('Kata Laluan telah berjaya ditukar. Sila Logout untuk mencuba Kata Laluan baru.')\""; 
	else if((isset($_GET['msg']) && $_GET['msg']=='passecn')) 
		echo "onload=\"MM_popupMsg('Kata Laluan baru tidak seragam apabila dibandingkan. Kata Laluan baru tidak dikemaskini. Sila cuba sekali lagi.')\"";  
	else if((isset($_GET['msg']) && $_GET['msg']=='passeco')) 
		echo "onload=\"MM_popupMsg('Sila pastikan ruangan \'Kata Laluan Lama\' dimasukkan dengan betul. Kata Laluan baru tidak dikemaskini')\"";   
	else if((isset($_GET['msg']) && $_GET['msg']=='passev')) 
		echo "onload=\"MM_popupMsg('Kata Laluan tidak sah. Sila cuba sekali lagi.')\""; 
		
	//error report
	if((isset($_GET['er']) && $_GET['er']=='1')) 
		echo "onload=\"MM_popupMsg('Laporan telah diluluskan. Mengemaskini tidak dapat dibuat.')\""; 
		
	//error courses
	if((isset($_GET['ec']) && $_GET['ec']=='1')) 
		echo "onload=\"MM_popupMsg('Kursus yang dicari tidak didaftarkan dalam sistem.')\"";
	else if((isset($_GET['ec']) && $_GET['ec']=='2')) 
		echo "onload=\"MM_popupMsg('Anda tidak dibenarkan untuk mengemaskini maklumat sendiri dalam modul ini.')\"";
	else if((isset($_GET['ec']) && $_GET['ec']=='3')) 
		echo "onload=\"MM_popupMsg('Anda telah membuat pengesahan kehadiran untuk kursus ini.')\"";
	else if((isset($_GET['ec']) && $_GET['ec']=='4')) 
		echo "onload=\"MM_popupMsg('PERHATIAN! Maklumat tidak dikemaskini kerana tarikh kursus masih belum atau sudah berlangsung. Sila berhubung dengan " . $GLOBALS['adname'] . " untuk maklumat lanjut.')\"";
			
	//error userlevel
	if((isset($_GET['eul']) && $_GET['eul']=='1')) 
		echo "onload=\"MM_popupMsg('Anda tidak mendapat akses kepada kandungan ini.')\"";
	else if((isset($_GET['eul']) && $_GET['eul']=='2')) 
		echo "onload=\"MM_popupMsg('Pertindihan pendaftaran, sila semak No. Staf ID dan Akses Level.')\"";
			
	//error salary
	if((isset($_GET['es']) && $_GET['es']=='1')) 
		echo "onload=\"MM_popupMsg('PERHATIAN! Transaksi pada Staf ID tersebut telah ada dalam rekod. \r\n\nUntuk perubahan sila tamatkan transaksi sebelum ini.')\"";
	if((isset($_GET['es']) && $_GET['es']=='2')) 
		echo "onload=\"MM_popupMsg('Semakkan Penyata Gaji masih dalam proses.')\"";	
			
	//error salary block
	if((isset($_GET['eusb']) && $_GET['eusb']=='1')) 
		echo "onload=\"MM_popupMsg('Pertindihan Bulan dan Tahun dalam rekod. Maklumat tidak dikemaskini.')\"";
		
	//error leave
	if((isset($_GET['el']) && $_GET['el']=='1')) 
		echo "onload=\"MM_popupMsg('Jumlah cuti melebihi daripada yang diperuntukkan mengikut tahun permohonan. Maklumat tidak disimpan.')\"";
	else if((isset($_GET['el']) && $_GET['el']=='2')) 
		echo "onload=\"MM_popupMsg('Cuti Bersalin hanya untuk staf wanita sahaja.')\"";
	else if((isset($_GET['el']) && $_GET['el']=='3')) 
		echo "onload=\"MM_popupMsg('Permohonan cuti pada tarikh tersebut tidak dibenarkan kerana telah bertindih dengan permohonan lain. Sila cuba tarikh lain.')\"";
	else if((isset($_GET['el']) && $_GET['el']=='4')) 
		echo "onload=\"MM_popupMsg('Permohonan cuti pada tarikh tersebut bertindih dengan cuti umum. Sila cuba tarikh yang lain.')\"";
	else if((isset($_GET['el']) && $_GET['el']=='5')) 
		echo "onload=\"MM_popupMsg('Tarikh yang dipilih merupakan hari Sabtu / Ahad. Sila cuba tarikh yang lain.')\"";
	else if((isset($_GET['el']) && $_GET['el']=='6')) 
		echo "onload=\"MM_popupMsg('Tarikh yang dipilih tidak wujud. Sila cuba tarikh lain.')\"";
	else if((isset($_GET['el']) && $_GET['el']=='7')) 
		echo "onload=\"MM_popupMsg('Anda tidak dibenarkan untuk mengemaskini maklumat sendiri dalam modul ini.')\"";
	else if((isset($_GET['el']) && $_GET['el']=='8')) 
		echo "onload=\"MM_popupMsg('Modul Cuti dalam proses kemaskini. Sila hubungi " . $GLOBALS['adname'] . " untuk maklumat lanjut.')\"";
		
	//error leave admin
	if((isset($_GET['euld']) && $_GET['euld']=='1')) 
		echo "onload=\"MM_popupMsg('Jumlah cuti melebihi daripada yang ditetapkan. Maklumat tidak disimpan.')\"";
			
	//error permenant
	if((isset($_GET['ep']) && $_GET['ep']=='1')) 
		echo "onload=\"MM_popupMsg('Maklumat ini hanya untuk Staf berstatus Tetap sahaja.')\"";
	else if((isset($_GET['ep']) && $_GET['ep']=='2')) 
	{
		if(isset($_GET['balance']) && $_GET['balance']!="")
			$msgt = "Baki GCR yang ditambah hanya " . htmlspecialchars($_GET['balance'], ENT_QUOTES) . " Hari";
		echo "onload=\"MM_popupMsg('Jumlah yang ditambah melebihi had yang ditetapkan. " . $msgt . "')\"";
	}
	else if((isset($_GET['ep']) && $_GET['ep']=='3')) 
	{
		if(isset($_GET['balance']) && $_GET['balance']!="")
			$msgt = "Cuti Dibawa Kehadapan yang ditambah hanya " . htmlspecialchars($_GET['balance'], ENT_QUOTES) . " Hari";
		else
			$msgt = '';
		echo "onload=\"MM_popupMsg('Jumlah yang ditambah melebihi baki Cuti Rehat / Tahunan. " . $msgt . "')\"";
	}
	else if((isset($_GET['ep']) && $_GET['ep']=='4')) 
	{
		if(isset($_GET['balance']) && $_GET['balance']!= NULL)
			$msgt = "Cuti Dibawa Kehadapan yang ditambah hanya " . htmlspecialchars($_GET['balance'], ENT_QUOTES) . " Hari";
		else
			$msgt = '';
		echo "onload=\"MM_popupMsg('Jumlah yang ditambah melebihi daripada yang ditetapkan. " . $msgt . "')\"";
	} else if((isset($_GET['ep']) && $_GET['ep']=='5')) 
	{
		echo "onload=\"MM_popupMsg('Rekod tidak dikemaskini. Sila cuba sekali lagi.')\"";
	}
	
	//ict borrow
	if(isset($_GET['eib']) && $_GET['eib']=='1') 
		echo "onload=\"MM_popupMsg('Pinjaman tidak diproses kerana tiada item yang dipilih. Sila cuba sekali lagi.')\""; 
	else if(isset($_GET['eib']) && $_GET['eib']=='2') 
		echo "onload=\"MM_popupMsg('Maklumat tidak diproses kerana tarikh tidak sah. Sila cuba sekali lagi.')\""; 
	else if(isset($_GET['eib']) && $_GET['eib']=='3') 
		echo "onload=\"MM_popupMsg('Maklumat tidak diproses kerana tempahan harian telah melebihi 3 kali.')\""; 
		
	//ict report
	if(isset($_GET['ea']) && $_GET['ea']=='1') 
		echo "onload=\"MM_popupMsg('Maklumat tidak diproses kerana jumlah aduan terkumpul harian tidak melebihi 5 kali.')\"";
	else if(isset($_GET['ea']) && $_GET['ea']=='2') 
		echo "onload=\"MM_popupMsg('Aduan telah selesai.')\"";
	else if(isset($_GET['ea']) && $_GET['ea']=='3') 
		echo "onload=\"MM_popupMsg('Isu tidak diproses kerana masih dalam semakkan dan penambahbaikkan.')\"";
	else if(isset($_GET['err'])) 
		echo "onload=\"MM_popupMsg("+$msgerr+"\"";
		
	//error harta report feedback
	if((isset($_GET['eh']) && $_GET['eh']=='1')) 
		echo "onload=\"MM_popupMsg('Pengesahan tidak boleh dilakukan kerana aduan masih dalam proses.')\""; 
	if((isset($_GET['eh']) && $_GET['eh']=='2')) 
		echo "onload=\"MM_popupMsg('Jumlah aduan harian telah melebihi daripada yang ditetapkan. Sila semak senarai aduan harian dalam Rekod.')\""; 
		
	//error SKT
	if((isset($_GET['eskt']) && $_GET['eskt']=='1')) 
		echo "onload=\"MM_popupMsg('Staf ID bagi PPP atau PPK tidak dikenalpasti. Sila semak Staf ID yang dimasukkan adalah betul dan aktif.')\""; 
	elseif((isset($_GET['eskt']) && $_GET['eskt']=='2')) 
		echo "onload=\"MM_popupMsg('Staf ID tidak didaftarkan dibawah Pegawai Penilai. Sila semak sekali lagi.')\""; 
	elseif((isset($_GET['eskt']) && $_GET['eskt']=='3')) 
		echo "onload=\"MM_popupMsg('Kesilapan pada maklumat Tempoh. Sila semak terlebih dahulu. Maklumat tidak diproses.')\""; 
	elseif((isset($_GET['eskt']) && $_GET['eskt']=='4')) 
		echo "onload=\"MM_popupMsg('Kesilapan pada maklumat Aktiviti. Sila semak terlebih dahulu. Maklumat tidak diproses.')\""; 
	elseif((isset($_GET['eskt']) && $_GET['eskt']=='5')) 
		echo "onload=\"MM_popupMsg('Kesilapan pada maklumat Sasaran Kerja. SKT yang ditetapkan hendaklah mengandungi sekurang-kurangnya satu Petunjuk Prestasi iaitu sama ada Kuantiti, Kualiti, Masa atau Kos bergantung kepada kesesuaian sesuatu aktiviti / projek. Maklumat tidak diproses.')\""; 
		
	//error upload
	if((isset($_GET['eup']) && $_GET['eup']=='1')) 
		echo "onload=\"MM_popupMsg('Saiz fail melebihi dari yang ditetapkan.')\""; 
	elseif((isset($_GET['eup']) && $_GET['eup']=='2')) 
		echo "onload=\"MM_popupMsg('Hanya fail berformat gambar sahaja dibenarkan.')\""; 
	elseif((isset($_GET['eup']) && $_GET['eup']=='3')) 
		echo "onload=\"MM_popupMsg('Resolusii gambar tidak mengikut ketetapan')\"";
		
	//ekad
	if((isset($_GET['ekad']) && $_GET['ekad']=='1')) 
		echo "onload=\"MM_popupMsg('Ekad telah berjaya dihantar.')\""; 
	elseif((isset($_GET['ekad']) && $_GET['ekad']=='2')) 
		echo "onload=\"MM_popupMsg('Email Pengguna tidak boleh diguna dalam ISN eKad ini. eKad tidak dihantar.')\""; 
	elseif((isset($_GET['ekad']) && $_GET['ekad']=='3')) 
		echo "onload=\"MM_popupMsg('Tiada Nama Penerima dan Email Penerima disertakan. Sila cuba sekali lagi.')\""; 
		
	// OT
	if((isset($_GET['eot']) && $_GET['eot']=='1')) 
		echo "onload=\"MM_popupMsg('Pertindihan Tarikh OT. Sila cuba sekali lagi.')\""; 
	elseif((isset($_GET['eot']) && $_GET['eot']=='2')) 
		echo "onload=\"MM_popupMsg('Tidak boleh menguruskan tuntutan kerja lebih masa bagi diri sendiri.')\""; 
		
	// Leave Office
	if((isset($_GET['etic']) && $_GET['etic']=='1')) 
		echo "onload=\"MM_popupMsg('Permohonan tidak diproses kerana maklumat yang dimasukkan tidak lengkap. Sila cuba sekali lagi.')\"";  
		
	// Leave Office
	if((isset($_GET['lo']) && $_GET['lo']=='1')) 
		echo "onload=\"MM_popupMsg('Pertindihan tarikh permohonan. Sila cuba sekali lagi.')\"";  

?>