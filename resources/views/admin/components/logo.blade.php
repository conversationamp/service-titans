 <!-- LOGO -->
 <a href="{{ route('dashboard') }}" class="logo">
     <span>
         <img src="{{ showLogo() }}" alt="logo-small" class="logo-sm"
             style="height: 50px !important; border-radius:100px; z-index:99999999999" onerror="this.src='{{ asset('assets/images/hts.png') }}'">
     </span>
     <span style="margin-top:5px" class="pb-2">
         {{-- <img src="{{ asset(settings('company_primary_logo', 1)) }}" alt="logo-large" class="logo-lg logo-light" style="height: 60px !important; border-radius:100px;">
        <img src="{{ asset(settings('company_primary_logo', 1)) }}" alt="logo-large" class="logo-lg logo-dark"> --}}
         <span class="logo-lg h3 font-weight-bold compl" style="">
             {{ showCompanyName() }} </span>
     </span>
 </a>
 <!--end logo-->
