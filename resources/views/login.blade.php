@extends('layouts.auth.master')

@section('title')
{{ $title }}
@endsection

@push('css')
<style>
    #show-hide {
        position: absolute;
        top: 18px;
        right: 30px;
        -webkit-transform: translateY(-50%);
        transform: translateY(-50%);
        text-transform: capitalize;
        z-index: 2;
    }

    #show-hide span {
        cursor: pointer;
        font-size: 13px;
        color: #24695c;
    }

    #show-hide span::before {
        content: attr(data-state);
    }

    .w-450 {
        width: 450px;
    }

    @media (max-width: 480px) {
        .w-450 {
            width: 100%;
        }
    }

    .btn-secondary2 {
        background-color: #ff9800 !important;
        border-color: #ff9800 !important;
    }

</style>
@endpush
@section('content')
<section>
    <div class="container-fluid">
        <div class="row">
            <img class="bg-img-cover bg-center" src="{{ asset('assets/images/login/4.png') }}" alt="looginpage"/>
            <div class="login-card">
                <form class="theme-form login-form mb-3" onsubmit="return false;" data-form>
                    <div class="text-center"><a href="#">
                            <h4>Masuk SITAMPAN</h4>
                            <h6 style="margin-top:10px">Selamat datang, Silahkan login ke akun kamu.</h6>
                    </div>
                    {{ csrf_field() }}
                    <div class="mb-3">
                        <label>NIK</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="icon-user"></i></span>
                            <input type="text" class="form-control" name="nik" autocomplete="off" maxlength="16" autofocus>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label>Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="icon-lock"></i></span>
                            <input class="form-control" type="password" name="password" />
                            <div id="show-hide"><span data-state="show"></span></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary btn-block" type="submit" data-submit-btn>Masuk</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@push('scripts')
<script>
    $(document).ready(function () {
        $("[data-form]").submit(function (e) {
            $.ajax({
                url: "{{ url('/login') }}",
                type: "POST",
                data: new FormData(this),
                dataType: "json",
                processData: false,
                contentType: false,
                beforeSend: function () {
                    $("[data-submit-btn]").attr("disabled", true);
                },
                success: function (response) {
                    $("[data-submit-btn]").attr("disabled", false);
                    if (response.status_code == 500) return toastAlert("error", response
                        .message);
                    
                    if(response.status_code == 400) return populateErrorMessage(response.errors);
                    
                    toastAlert("success", response.message);
                    setTimeout(function () {
                        window.location.href = "{{ url('/dashboard') }}";
                    }, 2000);
                },
                error: function (reject) {
                    $("[data-submit-btn]").attr("disabled", false);
                    toastAlert("error", "Terjadi kesalahan pada server");
                }
            })
        })

        $(document).on("submit", "form", function () {
            $(".form-control").removeClass("is-invalid");
            $(".invalid-feedback").remove();
        });

        function populateErrorMessage(errors) {
            var ObjToArray = Object.entries(errors);
            ObjToArray.forEach((value) => {
            var input = $(`[name='${value[0]}']`);
            var feedback = `<div class='invalid-feedback'>${value[1][0]}</div>`;
            if (input.length > 1) {
                $(`[data-input='${value[0]}']`).append(`<p class='d-block invalid-feedback text-danger' style='margin-top: 0.25rem; font-size: 0.875em'>${value[1][0]}</p>`);
            } else {
                input.addClass("is-invalid");
                input.after(feedback);
            }
            });
        }

        $("#show-hide").click(function () {
            var passwordEl = $("[name='password']");
            var stateEl = $("[data-state]");

            if (passwordEl.attr("type") == "password") {
                passwordEl.attr("type", "text");
                stateEl.attr("data-state", "hide");
            } else {
                passwordEl.attr("type", "password");
                stateEl.attr("data-state", "show");
            }
        });
    });

</script>
@endpush

@endsection
