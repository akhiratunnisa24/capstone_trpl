<!DOCTYPE html>
<html>
<head>
    <title>Penerimaan di Perusahaan Global Risk Management Pemberitahuan - Rekruitmen GRM Posisi {{ $posisi }}</title>
</head>
<body>
    @if ($data->jenis_kelamin == 'L')
    <strong>Kepada Yth. Bapak {{ $data->nama }}</strong>
    @else
    <strong> Kepada Yth. Ibu {{ $data->nama }}</strong>
    @endif
    <br><br>
    {{-- <p>Anda memiliki notifikasi permintaan <strong>{{$data['id_jeniscuti']}}</strong> dari Saudara/i <strong>{{Auth::user()->id_pegawai}}</strong></p> --}}
    <p>Kami senang untuk memberitahu Anda bahwa Anda telah diterima sebagai {{ $lowongan->posisi }} di Perusahaan ABC. Kami sangat terkesan dengan pengalaman dan keterampilan yang Anda miliki, serta dengan antusiasme Anda untuk bergabung dengan tim kami.</p>
    <p>Sebagai langkah awal, kami akan meminta Anda untuk mengirimkan salinan dokumen-dokumen yang diperlukan untuk proses pengambilan keputusan, seperti sertifikat pendidikan terakhir, kartu identitas, serta surat keterangan sehat dari dokter. Kami juga akan memberikan informasi mengenai gaji, jadwal kerja, dan manfaat yang akan Anda terima di perusahaan kami.</p>
    <p>Selamat bergabung dengan tim Perusahaan ABC! Kami berharap untuk bekerja sama dengan Anda dan mencapai kesuksesan bersama-sama.</p>
    <br>
    
    <p>Salam Hormat,<br><br></p>
    <p>HRD PT. Global Risk Management</p>
    </div>
    <div class="footer">
			<p>Email ini dikirimkan secara otomatis. Jangan membalas email ini karena tidak akan terbaca. Hubungi kami di <b><a href="mailto:">info@grm-risk.com</a></b> atau anda bisa menghubungi <a href="#">(+62) 811-140-840-5</a> untuk informasi lebih lanjut.</p>
		</div>
</body>
</html>