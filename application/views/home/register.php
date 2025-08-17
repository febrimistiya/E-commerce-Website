
<!-- Contact Start -->
<div class="container-fluid pt-5">
    <div class="text-center mb-4">
        <h2 class="section-title px-5"><span class="px-2">Halaman Registrasi</span></h2>
    </div>
    <div class="row px-xl-5">
        <div class="col-lg-7 mb-5">
            <div class="contact-form">
                <form name="sentMessage" method="post" action="<?php echo site_url('main/save_reg');?>">
                    <div class="control-group">
                        <input type="text" name="nama" class="form-control" id="name" placeholder="Nama" required="required" data-validation-required-message="Please enter your name" />
                        <p class="help-block text-danger"></p>
                    </div>
                    <div class="control-group">
                        <input type="text" name="email" class="form-control" id="emfail" placeholder="Email" required="required" data-validation-required-message="Please enter your email" />
                        <p class="help-block text-danger"></p>
                    </div>
                    <div class="control-group">
                        <input type="text" name="telpon" class="form-control" id="email" placeholder="Telpon" required="required" data-validation-required-message="Please enter your email" />
                        <p class="help-block text-danger"></p>
                    </div>
                    <div class="control-group">
                        <input type="text" name="username" class="form-control" id="email" placeholder="Username" required="required" data-validation-required-message="Please enter your email" />
                        <p class="help-block text-danger"></p>
                    </div>
                    <div class="control-group">
                        <select required id="province" name="province" class="form-control" placeholder="Provinsi">
                            <option>Pilih Provinsi</option>
                        </select>
                        <p class="help-block text-danger"></p>
                    </div>
                    <div class="control-group">
                        <select required id="city" name="city" class="form-control" placeholder="Kota">
                            <option value=''>Pilih Kota</option>
                        </select>
                        <p class="help-block text-danger"></p>
                    </div>
                    <div class="control-group">
                        <input type="password" name="password" class="form-control" id="email" placeholder="Password" required="required" data-validation-required-message="Please enter your email" />
                        <p class="help-block text-danger"></p>
                    </div>
                    <div class="control-group">
                        <textarea class="form-control" rows="3" id="message" name="alamat" placeholder="Alamat" required="required" data-validation-required-message="Please enter your message"></textarea>
                        <p class="help-block text-danger"></p>
                    </div>
                    <div>
                        <button class="btn btn-primary text-white py-2 px-4" type="submit" id="sendMessageButton">Daftar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    function getProvince() {
        $.ajax({
            type: 'GET',
            url: "<?php echo site_url('main/getProvince');?>",
            success: function(hasil) {
                console.log(hasil);
                $("#province").html(hasil);
            }
        })
    }

    $('#province').change(function() {
        $.ajax({
            type: 'GET',
            url: "<?php echo site_url('main/getCity');?>"+"/"+$('#province').val(),
            success: function(hasil) {
                console.log(hasil);
                $("#city").html(hasil);
            }
        });
    });
    
    getProvince();
</script>
