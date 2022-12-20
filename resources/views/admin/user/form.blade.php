@csrf
                         <div class="form-group row">
                             <div class="col-md-12">
                                 <label for="name">Name *</label>
                                 <input type="text" placeholder="Name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $data->name??'') }}" id="name" autocomplete="off">
                                 @error('name')
                                 <span class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </span>
                                 @enderror
                             </div>
                        </div>
                         <div class="form-group row">
                             <div class="col-md-12">
                                 <label for="email">Email *</label>
                                 <input type="text" placeholder="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $data->email??'') }}" id="email" autocomplete="off" >
                                 @error('email')
                                 <span class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </span>
                                 @enderror
                             </div>
                        </div>
                        @if(auth()->user()->role==admin_role())
                        {{-- <div class="form-group row">
                            <div class="col-md-12">
                                <label for="api_key">Agency API Key *</label>
                                <textarea placeholder="Api Key" class="form-control @error('api_key') is-invalid @enderror" name="api_key" >{{$data->ghl_api_key ?? ''}}</textarea>
                                @error('api_key')
                                <span class="invalid-feedback">
                                   <strong>{{ $message }}</strong>
                               </span>
                                @enderror
                            </div>
                       </div> --}}
                       <div class="form-group row">
                        <div class="col-md-12">
                            <label for="location">Location *</label>
                            <input  placeholder="Location" class="form-control @error('location') is-invalid @enderror" name="location" value="{{$data->location ?? ''}}"/>

                            @error('location')
                            <span class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    @endif
                       <div class="form-group row">
                        <div class="col-md-12">
                            <label for="api_key">Password </label>
                            <div class="input-group">
                                <input type="password" id="password" name="password" class="form-control" placeholder="Password">
                            </div>
                            @error('password')
                            <span class="invalid-feedback">
                               <strong>{{ $message }}</strong>
                           </span>
                            @enderror
                        </div>
                   </div>