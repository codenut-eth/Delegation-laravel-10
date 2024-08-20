@extends('frontend.layouts.master')

@section('meta')
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name='copyright' content=''>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="keywords" content="online shop, purchase, cart, ecommerce site, best online shopping">
<meta name="description" content="{{$delegation->work_content}}">
<meta property="og:url" content="{{route('product-detail',$delegation->id)}}">
<meta property="og:type" content="article">
<meta property="og:title" content="{{$delegation->name}}">
<meta property="og:description" content="{{$delegation->work_content}}">
@endsection
@section('title','E-SHOP || PRODUCT DETAIL')
@section('main-content')

<!-- Breadcrumbs -->
<div class="breadcrumbs">
 <div class="container">
  <div class="row">
   <div class="col-12">
    <div class="bread-inner">
     <ul class="bread-list">
      <li><a href="{{route('home')}}">Home<i class="ti-arrow-right"></i></a></li>
      <li class="active"><a href="">Delegation Details</a></li>
     </ul>
    </div>
   </div>
  </div>
 </div>
</div>
<!-- End Breadcrumbs -->

<section class="shop single section">
 <div class="container">
  <div class="row">
   <div class="col-12">
    <div class="row">

     <div class="col-lg-6 col-12">
      <div class="product-des">
       <!-- Description -->
       <div class="short">
        <h4>{{$delegation->name}}</h4>
        <div class="rating-main">
         <span>{{$delegation->rat_info->date}} TASK</span>
         @if($types)
         <div class="size">
          ({{$types}})
         </div>
         @endif
        </div>
       </div>
       <!--/ End Size -->
      </div>
     </div>
    </div>
    <div class="row">
     <div class="col-12">
      <div class="product-info">
       <div class="nav-main">
        <!-- Tab Nav -->
        <ul class="nav nav-tabs" id="myTab" role="tablist">
         <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#work_content" role="tab">Work Content</a></li>
         <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#work_result" role="tab">Work Result</a></li>
        </ul>
        <!--/ End Tab Nav -->
       </div>
       <div class="tab-content" id="myTabContent">
        <!-- Work Content Tab -->
        <div class="tab-pane fade show active" id="work_content" role="tabpanel">
         <div class="tab-single">
          <div class="row">
           <div class="col-12">
            <div class="single-des">
             <p>{!! html_entity_decode($delegation->work_content) !!}</p>
            </div>
           </div>
          </div>
         </div>
        </div>
        <!--/ End Work Content Tab -->
        <!-- Work Result Tab -->
        <div class="tab-pane fade" id="work_result" role="tabpanel">
         <div class="tab-single review-panel">
          <div class="row">
           <div class="col-12">
            <div class="add-review">
             <h6 id="total-amount"></h6>
             <table class="table table-bordered text-center" id="user-dataTable" width="100%" cellspacing="0">
              <thead>
               <tr>
                <th class="text-primary">Name</th>
                @for ($i=1; $i<13; $i++) <th>{{ $i }}</th>
                 @endfor
                 <th class="text-danger">Sum</th>
               </tr>
              </thead>
              <tbody>
              </tbody>
             </table>
            </div>
           </div>
          </div>
         </div>
        </div>
        <!--/ End Work Result Tab -->
       </div>
      </div>
     </div>
    </div>
   </div>
  </div>
 </div>
</section>
@endsection

@push('scripts')
<script>
 $(document).ready(function() {
  const members = {!!json_encode($members) !!};
  let total = 0;

  function drawTable() {
   const tbody = $('#user-dataTable tbody');
   tbody.empty();
   let total = 0;
   members.forEach(member => {
    const workResults = JSON.parse(member.work_results);
    const totalMonths = Array(12).fill(0);
    workResults.forEach(result => {
     result.months.forEach((value, index) => {
      totalMonths[index] += parseInt(value);
     });
    });
    let sum = totalMonths.reduce((acc, curr) => acc + Number(curr), 0);
    console.log(sum)
    total += sum;
    if (totalMonths) {
     let monthlySums = totalMonths.map((month, index) => {
      return `<td class="month-td">${month}</td>`;
     });

     let row = $(`
      <tr>
       <td class="text-primary">${member.name}</td>
       ${monthlySums.join('')}
       <td class="text-danger">${sum}</td>
      </tr>
     `);

     tbody.append(row);
    }
   });
   $('#total-amount').text(`Total Amount: ${total}`);
  }

  drawTable();
 });
</script>
@endpush