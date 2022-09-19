<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@yield('title')</title>
    <!-- Google font-->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap" rel="stylesheet">
    <!-- Font Awesome-->
    @includeIf('layouts.admin.partials.css')
  </head>
  <body>
    <!-- Loader starts-->
    <div class="loader-wrapper">
      <div class="theme-loader"></div>
    </div>
    <!-- Loader ends-->
    <!-- page-wrapper Start-->
    <div class="page-wrapper" id="pageWrapper">
      <!-- Page Header Start-->
      @includeIf('layouts.admin.partials.header')
      <!-- Page Header Ends -->
      <!-- Page Body Start-->
      <div class="page-body-wrapper horizontal-menu">
        <!-- Page Sidebar Start-->
        @includeIf('layouts.admin.partials.sidebar')
        <!-- Page Sidebar Ends-->
        <div class="page-body">
          <!-- Container-fluid starts-->
          @yield('content')
          <!-- Container-fluid Ends-->
        </div>
        <!-- footer start-->
        <footer class="footer footer">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-12 footer-copyright">
                <p class="mb-0">Copyright ©</p>
              </div>
             
            </div>
          </div>
        </footer>
      </div>
    </div>
    <div class="modal" tabindex="-1" data-form-modal>
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" data-modal-title></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body" data-modal-body></div>
        </div>
      </div>
    </div>
    <!-- latest jquery-->
    @includeIf('layouts.admin.partials.js')          

    <script>
      var formModal;
      
      document.querySelector("[data-form-modal]").addEventListener("hidden.bs.modal", function() {
        document.querySelector("[data-modal-title]").innerText = "";
        document.querySelector("[data-modal-body]").innerHTML = "";
      });

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
      
      $(document).on("input", ".numeric", function() {
          this.value = this.value.replace(/\D/g,'');
      });

      $(document).on("input", ".comma", function() {
        this.value = addCommas(this.value)
      });

      $(document).ready(function() {
          $(".uiselect").select2();
      });
      
      $('body').on('shown.bs.modal', '.modal', function() {
          $('#commodity_type').on('change', function () {
            var value = $(this).val();
            console.log(value)
            if (value) {
                $.ajax({
                    url: '{{ url('/api/commodity/') }}' + '/' + value,
                    type: "GET",
                    dataType: "json",
                    success: function (data) {
                        var commodity = data.data
                        $('select[name="id_komoditas"]').empty();
                        $('select[name="id_komoditas"]').append('<option value="">Pilih Komoditas</option>');
                        $('#commodity').select2({
                            placeholder: 'Pilih Komoditas',
                            allowClear: true
                        });
                        $.each(commodity, function (i, item) {
                            $('select[name="id_komoditas"]').append('<option value="'+item.id+
                                '">' + item.nama_komoditas + '</option>');
                        });                          
                    }
                });
            } else {
                $('select[name="id_komoditas"]').empty();
            }
          }); 

          $('#kecamatan').on('change', function () {
            var value = $(this).val();
            if (value) {
                $.ajax({
                    url: '{{ url('/api/village/') }}' + '/' + value,
                    type: "GET",
                    dataType: "json",
                    success: function (data) {
                      var village = data.data
                      $('select[name="nama_desa"]').empty();
                      $.each(village, function (i, item) {
                          $('select[name="nama_desa"]').append('<option value="'+item.nama_desa+
                              '">' + item.nama_desa + '</option>');
                      });                          
                    }
                });
            } else {
                $('select[name="nama_desa"]').empty();
            }
          });   

          $('#id_kecamatan').on('change', function () {
              var value = $(this).val();
              if (value) {
                  $.ajax({
                      url: '{{ url('/api/village-geo/') }}' + '/' + value,
                      type: "GET",
                      dataType: "json",
                      success: function (data) {
                          var village = data.data
                          $('select[name="id_desa"]').empty();
                          $('select[name="id_desa"]').append('<option value="">Pilih Desa</option>');
                          $('#desa').select2({
                              placeholder: 'Pilih Desa',
                              allowClear: true
                          });
                          $.each(village, function (i, item) {
                              $('select[name="id_desa"]').append('<option value="'+item.id+
                                  '">' + item.nama_desa + '</option>');
                          });                          
                      }
                  });
              } else {
                  $('select[name="id_desa"]').empty();
              }
          }); 


          $(this).find('.uiselect').each(function() {
              $(this).select2({ dropdownParent: $('.modal') });
          });
      });

      $('.modal').on('scroll', function (event) {
            $(this).find(".uiselect").each(function () {
                $(this).select2({ dropdownParent: $(this).parent() });
            });
      });
      
      function openForm(url, type = "create") {
        var title = {
          create: "Tambah Data",
          edit: "Edit Data",
          detail: "Detail Data",
        };

        var modalTitle  = title[type] ? title[type] : "";

        $.ajax({
          url: url,
          type: "GET",
          success: function(response) {
            $("[data-modal-title]").text(modalTitle);
            $("[data-modal-body]").html(response);
            formModal = new bootstrap.Modal(document.querySelector("[data-form-modal]"), {});
            formModal.show();
          },
          error: function(reject) {
            toastAlert("error", "Terjadi kesalahan pada server");
            console.log(reject)
          }
        })
      }

      function deleteAlert(url) {
        Swal.fire({
          title: 'Yakin ingin menghapus data?',
          text: "Kamu tidak bisa mengembalikan data ini lagi!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Ya, Hapus!',
          cancelButtonText: 'Batal'
        }).then(function(result) {
          if (!result.isConfirmed) return;
          $.ajax({
            url: url,
            type: "DELETE",
            success: function(response) {
                if (response.status_code == 500) return toastAlert("error", response.message);

                toastAlert("success", response.message);
                dt.ajax.reload();
            },
            error: function(reject) {
                toastAlert("error", "Terjadi kesalahan pada server");
            }
          })
        })
      }
    </script>

    <script>
      function logout() {
        $.ajax({
          url: "{{ url('logout') }}",
          type: "GET",
          beforeSend: function() {
            toastAlert("info", "Mencoba logout");
          },
          success: function() {
            window.location.replace("{{ url('login') }}");
          },
          error: function(reject) {
            console.log(reject);
          }
        })
      }
    </script>  
  </body>
</html>