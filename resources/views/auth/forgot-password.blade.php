<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title data-i18n="title">
        Forgot Password - Hela Bojun
    </title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

</head>


<body class="login-body">


<header class="top-header">
    <div class="container-fluid px-4">
        <div class="d-flex align-items-center justify-content-between header-wrapper">

            <!-- Logo + Department -->
            <div class="d-flex align-items-center gap-3">

                <img src="https://upload.wikimedia.org/wikipedia/commons/5/5f/Emblem_of_Sri_Lanka.svg"
                     class="emblem-img"
                     alt="Sri Lanka Emblem">

                <div class="department-text">

                    <h1 class="title-si">
                        කෘෂිකර්ම දෙපාර්තමේන්තුව
                    </h1>

                    <h2 class="title-en">
                        DEPARTMENT OF AGRICULTURE
                    </h2>

                    <h3 class="title-ta">
                        விவசாயத் திணைக்களம்
                    </h3>

                </div>

            </div>


            <!-- Language -->
            <div class="header-actions">

                <div class="dropdown">

                    <button class="language-btn dropdown-toggle"
                            data-bs-toggle="dropdown">

                        🌐

                    </button>


                    <ul class="dropdown-menu dropdown-menu-end shadow">

                        <li>
                            <button class="dropdown-item"
                                    onclick="changeLanguage('en')">
                                English
                            </button>
                        </li>


                        <li>
                            <button class="dropdown-item"
                                    onclick="changeLanguage('si')">
                                සිංහල
                            </button>
                        </li>


                        <li>
                            <button class="dropdown-item"
                                    onclick="changeLanguage('ta')">
                                தமிழ்
                            </button>
                        </li>

                    </ul>

                </div>

            </div>


        </div>
    </div>
</header>


<div class="login-container">

    <div class="card login-card border-0 shadow-lg">

        <div class="card-body p-4 p-sm-5">


            <!-- Logo -->
            <div class="text-center mb-4">

                <img src="{{ asset('images/hela-bojun-logo.png') }}"
                     class="login-logo mb-2"
                     alt="Hela Bojun Logo">


                <h4 class="fw-bold text-success-dark"
                    data-i18n="forgot_title">

                    Forgot Password

                </h4>


                <p class="text-muted small"
                   data-i18n="forgot_message">

                    Enter your email address and we will send you a password reset link.

                </p>

            </div>



            <!-- Status Message -->

            @if (session('status'))

                <div class="alert alert-success small">

                    <i class="bi bi-check-circle-fill me-2"></i>

                    <span data-i18n="success_message">
                        Password reset link has been sent to your email.
                    </span>

                </div>

            @endif



            <!-- Error Message -->

            @if ($errors->any())

                <div class="alert alert-danger small">

                    <i class="bi bi-exclamation-triangle-fill me-2"></i>

                    <span data-i18n="error_message">
                        Please enter a valid email address.
                    </span>

                </div>

            @endif





            <form method="POST" action="{{ route('password.email') }}">

                @csrf


                <div class="mb-3">


                    <label class="form-label fw-semibold text-secondary"
                           data-i18n="email">

                        Email Address

                    </label>



                    <div class="input-group">


                        <span class="input-group-text bg-light border-end-0">

                            <i class="bi bi-envelope text-muted"></i>

                        </span>



                        <input type="email"
                               name="email"
                               value="{{ old('email') }}"
                               class="form-control bg-light border-start-0"
                               placeholder="Enter your email"
                               required
                               autofocus>


                    </div>



                    @error('email')

                        <span class="text-danger small">
                            {{ $message }}
                        </span>

                    @enderror


                </div>




                <button type="submit"
                        class="btn btn-success-custom w-100 py-2 fw-bold shadow-sm">


                    <i class="bi bi-send me-2"></i>


                    <span data-i18n="send_button">
                        Send Password Reset Link
                    </span>


                </button>



            </form>



            <hr class="my-4 text-muted opacity-25">




            <div class="text-center">


                <a href="{{ route('login') }}"
                   class="small text-decoration-none text-secondary"
                   data-i18n="back_login">


                    ← Back to Login


                </a>


            </div>



        </div>

    </div>

</div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script><script>

const translations = {


en: {

title:"Forgot Password - Hela Bojun",

forgot_title:"Forgot Password",

forgot_message:"Enter your email address and we will send you a password reset link.",

email:"Email Address",

send_button:"Send Password Reset Link",

back_login:"← Back to Login",

success_message:"Password reset link has been sent to your email.",

error_message:"Please enter a valid email address."

},



si: {

title:"මුරපදය අමතකද - හෙළ බොජුන්",

forgot_title:"මුරපදය අමතකද?",

forgot_message:"ඔබගේ විද්‍යුත් තැපැල් ලිපිනය ඇතුළත් කරන්න. මුරපදය නැවත සැකසීමේ සබැඳියක් ඔබට එවනු ලැබේ.",

email:"විද්‍යුත් තැපැල් ලිපිනය",

send_button:"මුරපද නැවත සැකසීමේ සබැඳිය යවන්න",

back_login:"← පිවිසුමට ආපසු යන්න",

success_message:"මුරපද නැවත සැකසීමේ සබැඳිය ඔබගේ විද්‍යුත් තැපෑලට යවා ඇත.",

error_message:"කරුණාකර නිවැරදි විද්‍යුත් තැපැල් ලිපිනයක් ඇතුළත් කරන්න."

},



ta: {

title:"கடவுச்சொல் மறந்துவிட்டீர்களா - ஹெல பொஜுன்",

forgot_title:"கடவுச்சொல் மறந்துவிட்டீர்களா?",

forgot_message:"உங்கள் மின்னஞ்சல் முகவரியை உள்ளிடவும். கடவுச்சொல் மீட்டமைப்பு இணைப்பு அனுப்பப்படும்.",

email:"மின்னஞ்சல் முகவரி",

send_button:"கடவுச்சொல் மீட்டமைப்பு இணைப்பை அனுப்பவும்",

back_login:"← உள்நுழைவுக்கு திரும்பவும்",

success_message:"கடவுச்சொல் மீட்டமைப்பு இணைப்பு உங்கள் மின்னஞ்சலுக்கு அனுப்பப்பட்டுள்ளது.",

error_message:"சரியான மின்னஞ்சல் முகவரியை உள்ளிடவும்."

}


};



function changeLanguage(lang){

localStorage.setItem('selectedLang',lang);


document.querySelectorAll('[data-i18n]').forEach(el=>{

let key = el.getAttribute('data-i18n');


if(translations[lang][key]){

el.innerText = translations[lang][key];

}

});


}



document.addEventListener("DOMContentLoaded",()=>{

let lang = localStorage.getItem('selectedLang') || 'en';

changeLanguage(lang);

});


</script>


</body>

</html>