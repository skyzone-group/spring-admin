<?php $__env->startSection('content'); ?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Управление продукты</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>"><?php echo app('translator')->get('global.home'); ?></a></li>
                        <li class="breadcrumb-item active">Управление продукты</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Продукты</h3>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('permission.add')): ?>
                            <a href="<?php echo e(route('productAdd')); ?>" class="btn btn-success btn-sm float-right">
                                <span class="fas fa-plus-circle"></span>
                                <?php echo app('translator')->get('global.add'); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <!-- Data table -->
                        <table id="dataTable" class="table table-bordered table-striped dataTable dtr-inline table-responsive-lg" role="grid" aria-describedby="dataTable_info">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Название на русском</th>
                                <th>Название на узбекском</th>

                                <th>Цена</th>
                                <th>Изображение</th>
                                <th>Категории</th>
                                <th>Activate</th>
                                <th class="w-25"><?php echo app('translator')->get('global.actions'); ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($product->id); ?></td>
                                    <td><?php echo e($product->name_ru); ?></td>
                                    <td><?php echo e($product->name_uz); ?></td>

                                    <td><?php echo e($product->price); ?></td>
                                    <td><a target="_blank"  href="<?php echo e(config('constants.bot.photo_url').$product->photo); ?>"><?php echo e($product->photo); ?></a> </td>
                                    <td><?php echo e(isset($product->category->name_ru) ? $product->category->name_ru : 'Deleted'); ?></td>
                                    <td class="text-center">
                                        <i style="cursor: pointer" id="product_<?php echo e($product->id); ?>" class="fas <?php echo e($product->in_stock ? "fa-check-circle text-success":"fa-times-circle text-danger"); ?>"
                                           onclick="toggle_instock(<?php echo e($product->id); ?>)" ></i>
                                    </td>
                                    <td class="text-center">
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('permission.delete')): ?>
                                            <form action="<?php echo e(route('productDestroy',$product->id)); ?>" method="post">
                                                <?php echo csrf_field(); ?>
                                                <div class="btn-group">
                                                    
                                                    <a href="<?php echo e(route('productEdit',$product->id)); ?>" type="button" class="btn btn-info btn-sm"> <?php echo app('translator')->get('global.edit'); ?></a>
                                                    
                                                    <input name="_method" type="hidden" value="DELETE">
                                                    <button type="button" class="submitButton btn btn-danger btn-sm"> <?php echo app('translator')->get('global.delete'); ?></button>
                                                </div>
                                            </form>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script>
        function toggle_instock(id){
            $.ajax({
                url: "/product/toggle-status/"+id,
                type: "POST",
                data:{
                    _token: "<?php echo @csrf_token(); ?>"
                },
                success: function(result){
                    if (result.is_active == 1){
                        $("#product_"+id).attr('class',"fas fa-check-circle text-success");
                    }
                    else
                    {
                        $("#product_"+id).attr('class',"fas fa-times-circle text-danger");
                    }
                },
                error: function (errorMessage){
                    console.log(errorMessage)
                }
            });
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/t92074/public_html/spring-organic.skybox.uz/resources/views/pages/product/index.blade.php ENDPATH**/ ?>