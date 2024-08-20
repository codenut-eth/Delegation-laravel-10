@extends('frontend.layouts.master')

@section('title','E-SHOP || PRODUCT PAGE')

@section('main-content')
<div class="breadcrumbs">
 <div class="container">
  <div class="row">
   <div class="col-12">
    <div class="bread-inner">
     <ul class="bread-list">
      <li><a href="{{route('home')}}">Home<i class="ti-arrow-right"></i></a></li>
      <li class="active"><a href="blog-single.html">Delegation list</a></li>
     </ul>
    </div>
   </div>
  </div>
 </div>
</div>

<form action="" method="POST">
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
      {{-- {{$delegations}} --}}
      @if(count($delegations)>0)
      @foreach($delegations as $delegation)
      <div class="col-lg-4 col-md-6 col-12">
       <a href="{{route('delegation-detail',$delegation->id)}}">
        <div class="single-product">
         <div class="rat-title">
          <span>
          {{$delegation->name}}
          @if ($delegation->type)
          <span>({{\App\Models\DelegationType::getTypeName($delegation->type)}})</span>
          @endif
         </span>
         </div>
         <div class="product-content">
          <span>{{ $delegation->rat_info->date }} TASK</span>
          
          <h3><a href="{{route('delegation-detail',$delegation->id)}}">{!! html_entity_decode($delegation->work_content) !!}</a></h3>
         </div>
        </div>
       </a>
      </div>
      @endforeach
      @else
      <h4 class="text-warning" style="margin:100px auto;">There are no Delegations.</h4>
      @endif
     </div>
    </div>
   </div>
  </div>
 </section>
</form>

@endsection
