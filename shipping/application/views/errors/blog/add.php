<div class="block">
    <div class="block-title">
        <div class="block-options pull-right">
            <!-- <a href="javascript:void(0)" class="btn btn-alt btn-sm btn-default toggle-bordered enable-tooltip" data-toggle="button" title="Toggles .form-bordered class">No Borders</a> -->
        </div>
        <h2><strong>Form</strong> Tambah Blog</h2>
    </div>

    <form action="<?php echo base_url('blog/save');?>" method="post" class="form-horizontal form-bordered" enctype="multipart/form-data" >

        <div class="form-group">
            <label class="col-md-3 control-label" for="example-hf-email">Judul</label>
            <div class="col-md-5">
                <input type="text" id="nama" name="judul" class="form-control" required="" >
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-3 control-label" for="example-hf-email">Deskripsi</label>
            <div class="col-md-5">
                <textarea id="example-textarea-input" name="deskripsi" rows="9" class="form-control" ></textarea>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-3 control-label" for="example-hf-email">Tag</label>
            <div class="col-md-5">
                <select id="example-select2" name="tag" class="select-chosen" style="width: 100%;" data-placeholder="Choose one.." autocomplete="off">
                    <option></option>
                    <?php
                    $tag = $this->db->query("select * from tm_tag")->result_array();
                    foreach ($tag as $value) {
                         echo"<option value='".$value['id_tag']."'>".$value['tag']."</option>";
                    }
                    ?>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-3 control-label" for="example-hf-email">Foto</label>
            <div class="col-md-5">
                <input type="file" id="image" name="image" required="" >
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-3 control-label" for="example-hf-email">Status</label>
            <div class="col-md-5">
                <select class="form-control" name="status">
                    <option value="1">Aktif</option>
                    <option value="0">Tidak Aktif</option>
                </select>
            </div>
        </div>


        <div class="form-group form-actions">
            <div class="col-md-9 col-md-offset-3">
                <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-user"></i> Simpan</button>
                <button type="reset" class="btn btn-sm btn-warning"><i class="fa fa-repeat"></i> Reset</button>
            </div>
        </div>
    </form>
</div>

<script src="<?php echo base_url();?>assets/backend/js/vendor/jquery.min.js"></script>
<script src="<?php echo base_url();?>assets/backend/js/vendor/bootstrap.min.js"></script>
<script src="<?php echo base_url();?>assets/backend/js/plugins.js"></script>
<script src="<?php echo base_url();?>assets/backend/js/app.js"></script>