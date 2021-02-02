 <div id="page-content">
                        <!-- Forum Header -->
    <div class="content-header">
        <div class="header-section">
            <h1>
               Data Blog
            </h1>
        </div>
    </div>
    <ul class="breadcrumb breadcrumb-top">
        <li>Beranda</li>
        <li><a href="">Blog</a></li>
    </ul>

<div class="block">
         <div class="block-title">
            <ul class="nav nav-tabs" data-toggle="tabs">
                <li class="active"><a href="#forum-categories">Blog</a></li>
                <li><a href="#forum-topics" onclick="tambah()">Tambah Baru</a></li>
                <!-- <li><a href="#forum-discussion">Discussion</a></li> -->
            </ul>
        </div>

        <!-- Tab Content -->
        <div class="tab-content">
            <!-- Forum -->
            <div class="tab-pane active" id="forum-categories">
               <div class="table-responsive">
                <table id="example-datatable" class="a table table-striped table-vcenter">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Judul</th>
                            <th class="text-center">Deskripsi</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                       <?php $no=1; foreach ($blog as $key => $value) { ?>
                        <tr>
                            <td class="text-center"><?php echo $no++;?></td>
                            <td class="text-center"><?php echo $value['judul'];?></td>
                            <td class="text-center"><?php echo $value['deskripsi'];?></td>
                            <td class="text-center">
                                <a href="<?php echo base_url('bed/edit/'.$value['id_blog']);?>" data-toggle="tooltip" title="Edit" class="btn btn-alt btn-xs btn-primary" onclick="edit();">
                                    <i class="fa fa-pencil"></i> &nbsp
                                </a> 

                                <a href="<?php echo base_url('bed/delete/'.$value['id_blog']);?>" data-toggle="tooltip" title="Delete" class="btn btn-alt btn-xs btn-danger" onclick="return confirm('Apakah anda yakin akan menghapus Data ini ?')">
                                        <i class="hi hi-trash"></i>
                                    </a>
                            </td>
                        </tr>
                        <?php } ?>
                        
                    </tbody>
                </table>
            </div>
                <!-- END Support Category -->
            </div>
            <!-- END Forum -->

            <!-- Topics -->
            <div class="add tab-pane" id="forum-topics">

            </div>
            <!-- END Topics -->
        </div>
        <!-- END Tab Content -->
    </div>

<script type="text/javascript">
    function tambah(halaman){
        $('#loader'); 
        $.ajax({
            url      : '<?php echo base_url();?>blog/add',
            type     : 'POST',
            dataType : 'html',
            data     : 'widget='+halaman,
            success  : function(jawaban){
                $('.add').html(jawaban);
            },
        })
    }
</script>

</div>



