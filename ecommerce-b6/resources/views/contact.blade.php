@extends('template.layout')

@section('title', 'Contact Us')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0">
                <div class="card-body p-5">
                    <h2 class="mb-4 text-center">Contact Us</h2>
                    <p class="mb-4 text-center text-muted">Have questions, feedback, or need support? Fill out the form below and our team will get back to you as soon as possible.</p>
                    <form id="waForm" onsubmit="return sendToWhatsApp();">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" placeholder="Your Name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" placeholder="you@example.com" required>
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label">Message</label>
                            <textarea class="form-control" id="message" rows="5" placeholder="Type your message here..." required></textarea>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-success btn-lg"><i class="bi bi-whatsapp"></i> Kirim ke WhatsApp</button>
                        </div>
                    </form>
                    <script>
                        function sendToWhatsApp() {
                            var name = document.getElementById('name').value;
                            var email = document.getElementById('email').value;
                            var message = document.getElementById('message').value;
                            var phone = '6285964304112'; // Nomor WA tujuan (pakai 62 untuk Indonesia)
                            var text = `Halo, saya ${name} (%20${email}) ingin menghubungi Anda. Pesan: ${message}`;
                            var url = `https://wa.me/${phone}?text=${encodeURIComponent(text)}`;
                            window.open(url, '_blank');
                            return false;
                        }
                    </script>
                    <hr class="my-5">
                    <div class="text-center">
                        <h5 class="mb-2">Or reach us at:</h5>
                        <p class="mb-0"><i class="bi bi-envelope"></i> wahyucahyovebrian@gmail.com</p>
                        <p class="mb-0"><i class="bi bi-telephone"></i> +62 859-6430-4112</p>
                        <p><i class="bi bi-geo-alt"></i> Jl. Ki Ageng Gribig No.42 Madyopuro, Kedungkandang Kota Malang</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
