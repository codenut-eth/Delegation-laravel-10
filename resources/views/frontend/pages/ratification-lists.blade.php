@extends('frontend.layouts.master')

@section('title','E-SHOP || PRODUCT PAGE')

@section('main-content')

<form  method="POST">
 @csrf
 <section class="product-area shop-sidebar shop section">
  <div class="container">
   <div class="row">
    
    <div class="col-lg-12 col-md-12 col-12">
     <div class="row">
      <div class="col-12">
       <div class="shop-top">
        <div class="shop-shorter">
         <div class="single-shorter">
          <label>Show :</label>
          <select class="show" name="show" onchange="this.form.submit();">
           <option value="">Default</option>
           <option value="9" @if(!empty($_GET['show']) && $_GET['show']=='9' ) selected @endif>09</option>
           <option value="15" @if(!empty($_GET['show']) && $_GET['show']=='15' ) selected @endif>15</option>
           <option value="21" @if(!empty($_GET['show']) && $_GET['show']=='21' ) selected @endif>21</option>
           <option value="30" @if(!empty($_GET['show']) && $_GET['show']=='30' ) selected @endif>30</option>
          </select>
         </div>
        </div>
       </div>
      </div>
     </div>
     <div class="row">
      @if(count($ratifications)>0)
      @foreach($ratifications as $ratification)
      <div class="col-lg-4 col-md-6 col-12">
       <div class="single-product">
        <div class="rat-title"><span>{{$ratification->date}} TASK</span></div>
        <div class="product-content">
         <h3><a href="{{route('product-detail',$ratification->id)}}">{!!html_entity_decode($ratification->content)!!}</a></h3>
         <div class="delegation-list">
          @if(strlen($ratification->delegation) !== 0)
           @php $delegations = explode(",",$ratification->delegation); @endphp
           @foreach ($delegations as $delegation)
            <p>{{$delegation}}</p>
           @endforeach
          @endif
         </div>
        </div>
       </div>
      </div>
      @endforeach
      @else
      <h4 class="text-warning" style="margin:100px auto;">There are no ratifications.</h4>
      @endif
     </div>
    </div>
   </div>
  </div>
 </section>
</form>

@endsection
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
@endpush