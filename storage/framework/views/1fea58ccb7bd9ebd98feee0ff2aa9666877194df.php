 <!-- LOGO -->
 <a href="<?php echo e(route('dashboard')); ?>" class="logo">
     <span>
         <img src="<?php echo e(showLogo()); ?>" alt="logo-small" class="logo-sm"
             style="height: 50px !important; border-radius:100px; z-index:99999999999" onerror="this.src='<?php echo e(asset('assets/images/hts.png')); ?>'">
     </span>
     <span style="margin-top:5px" class="pb-2">
         
         <span class="logo-lg h3 font-weight-bold compl" style="">
             <?php echo e(showCompanyName()); ?> </span>
     </span>
 </a>
 <!--end logo-->
<?php /**PATH F:\xampp\htdocs\ServiceTitans\Service-Titans\resources\views/admin/components/logo.blade.php ENDPATH**/ ?>