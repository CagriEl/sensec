<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yeni Kent Meydanı & Yaşam Merkezi İsmi Öneri Sistemi</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body { font-family: 'Poppins', sans-serif; }
        
        .bg-custom {
            background-image: linear-gradient(rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.3)), url("{{ asset('images/background.svg') }}");
            background-size: cover;
            background-position: center bottom; /* Görsel alta yaslı kalmaya devam ediyor */
            background-attachment: fixed;
            background-repeat: no-repeat;
        }
        
        .glass-panel {
            background: rgba(255, 255, 255, 0.98);
            border-top: 5px solid #03a0db;
        }

        .text-brand { color: #03a0db; }
        .bg-brand { background-color: #03a0db; }
        .bg-brand-hover:hover { background-color: #0284b5; }
        .ring-brand:focus { --tw-ring-color: #03a0db; }
        .border-brand:focus { border-color: #03a0db; }
    </style>
</head>

<body class="bg-custom min-h-screen flex flex-col items-center justify-start pt-6 md:pt-10 px-4 pb-32">

    <div class="glass-panel w-full max-w-lg rounded-xl shadow-2xl overflow-hidden">
        
        <div class="p-8 text-center pb-4">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-blue-50 rounded-full mb-4 shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-10 h-10 text-brand">
                    <path fill-rule="evenodd" d="M11.54 22.351l.07.04.028.016a.76.76 0 00.723 0l.028-.015.071-.041a16.975 16.975 0 001.144-.742 19.58 19.58 0 002.683-2.282c1.944-1.99 3.963-4.98 3.963-8.827a8.25 8.25 0 00-16.5 0c0 3.846 2.02 6.837 3.963 8.827a19.58 19.58 0 002.682 2.282 16.975 16.975 0 001.145.742zM12 13.5a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
                </svg>
            </div>
            <h1 class="text-2xl md:text-3xl font-bold text-gray-800 tracking-tight leading-tight">
                Yeni Kent Meydanı & <br> Yaşam Merkezi
            </h1>
            <p class="text-brand font-semibold mt-2 text-sm tracking-wide uppercase">İsim Öneri Platformu</p>
            <p class="text-gray-500 mt-3 text-sm font-medium">Şehrimize değer katacak bu eserin ismi sizden olsun.</p>
        </div>

        <div class="px-8 pb-8 pt-2">
            <form action="{{ route('store') }}" method="POST" id="suggestionForm">
                @csrf
                
                <div class="mb-6">
                    <label for="name" class="block text-gray-700 text-sm font-bold mb-2 uppercase tracking-wider">
                        Önerdiğiniz İsim
                    </label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-gray-400 group-focus-within:text-brand transition-colors duration-200">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                            </svg>
                        </div>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               class="w-full pl-10 pr-4 py-3.5 bg-gray-50 border border-gray-200 text-gray-800 rounded-lg focus:outline-none focus:ring-2 ring-brand border-brand transition duration-200 placeholder-gray-400 font-medium" 
                               placeholder="Örn: 100. Yıl Meydanı" 
                               required
                               autocomplete="off">
                    </div>
                    
                    @error('name')
                        <div class="flex items-center mt-2 text-red-500 text-xs font-bold animate-pulse">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 mr-1">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                            </svg>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <button type="submit" id="submitBtn" class="w-full bg-brand bg-brand-hover text-white font-semibold py-4 px-4 rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 flex items-center justify-center text-lg">
                    <span id="btnText">GÖNDER</span>
                    <svg id="arrowIcon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 ml-2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                    </svg>
                    <svg id="loadingIcon" class="animate-spin ml-2 h-5 w-5 text-white hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </button>
            </form>
            
            <p class="text-center text-xs text-gray-400 mt-6 font-light">
                 &copy; {{ date('Y') }} Park ve Bahçeler Müdürlüğü
            </p>
        </div>
    </div>

  <script>
    const form = document.getElementById('suggestionForm');
    const submitBtn = document.getElementById('submitBtn');
    const btnText = document.getElementById('btnText');
    const arrowIcon = document.getElementById('arrowIcon');
    const loadingIcon = document.getElementById('loadingIcon');
    const nameInput = document.getElementById('name');

    // Otomatik Büyük Harf
    nameInput.addEventListener('input', function() {
        this.value = this.value.toLocaleUpperCase('tr-TR');
    });

    form.addEventListener('submit', function(e) {
        const val = nameInput.value.trim();

        // 1. ÖN YÜZ KONTROLÜ: Çok kısa girişler
        if (val.length < 3) {
            e.preventDefault();
            Swal.fire({
                title: 'Çok Kısa',
                text: 'Lütfen en az 3 karakterden oluşan bir isim giriniz.',
                icon: 'warning',
                confirmButtonColor: '#03a0db',
                confirmButtonText: 'Tamam'
            });
            return;
        }

        // 2. ÖN YÜZ KONTROLÜ: Tekrarlayan Harfler (AAAAA)
        const repetitionRegex = /(.)\1{2,}/;
        if (repetitionRegex.test(val)) {
            e.preventDefault();
            Swal.fire({
                title: 'Geçersiz Giriş',
                text: 'Lütfen "AAAA" gibi tekrarlayan harfler kullanmayınız.',
                icon: 'warning',
                confirmButtonColor: '#03a0db',
                confirmButtonText: 'Düzelt'
            });
            return;
        }

        // Gönderiliyor animasyonu
        submitBtn.disabled = true;
        submitBtn.classList.add('opacity-80', 'cursor-not-allowed');
        btnText.innerText = 'İLETİLİYOR...';
        arrowIcon.classList.add('hidden');
        loadingIcon.classList.remove('hidden');
    });

    // BAŞARILI MESAJI
    @if(session('success'))
        Swal.fire({
            title: 'Teşekkür Ederiz',
            text: "{{ session('success') }}",
            icon: 'success',
            confirmButtonText: 'Tamam',
            confirmButtonColor: '#03a0db',
            iconColor: '#03a0db',
            timer: 5000,
            timerProgressBar: true
        });
    @endif

    // HATA MESAJI (Burayı Düzelttik!)
    @if($errors->any())
        Swal.fire({
            title: 'Uyarı',
            // ESKİ KOD: text: 'Lütfen girdiğiniz ismi kontrol ediniz.',
            // YENİ KOD (Aşağıdaki satır): Sunucudan gelen gerçek hatayı yazar.
            text: "{!! $errors->first() !!}", 
            icon: 'error',
            confirmButtonColor: '#03a0db',
            confirmButtonText: 'Tekrar Dene'
        });
    @endif
</script>
</body>
</html>