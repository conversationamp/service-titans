<div class="leftbar-profile p-3 w-100">
    <div class="media position-relative">
        <div class="leftbar ">
            <img src="{{ asset(auth()->user()->image) }}" alt="" class="thumb-md rounded-circle" onerror="this.src='{{ asset('assets/images/sabi.jpg') }}'">
        </div>
        <div class="media-body align-self-center text-truncate ml-3">
            <h5 class="mt-0 mb-1 font-weight-semibold">{{ auth()->user()->name }}</h5>
            @if(auth()->user()->role==0)
            <p class="text-uppercase mb-0 font-12">Super Admin  </p>
            @elseif(auth()->user()->role==1)
            <p class="text-uppercase mb-0 font-12"> Company Admin  </p>
           @else
            <p class="text-uppercase mb-0 font-12">  User </p>
            @endif
        </div><!--end media-body-->
    </div>
</div>
