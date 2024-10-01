@extends('layouts.admin-index')

@section('files')
    <script src="/js/html2pdf.js"></script>
@endsection
@section('body')

    <h4>Sales</h4>
    <hr>

    <form id="salesReportForm" class="mb-2">
        @csrf

        <h2 class="bg-secondary text-white rounded p-2 text-uppercase lead">Generate Sales Report</h2>

        <div class="mb-2 row align-items-center mb-2 text-dark">

            <div class="form-group col-sm col-md-5">
                <label for="from">From</label>
                <input class="form-control text-dark" id="from" name="from" type="date" required>
            </div>
            <div class="form-group col-sm col-md-5">
                <label for="to">To</label>
                <input class="form-control text-dark" id="to" name="to" type="date" required>
            </div>

            <div class="form-group col-sm col-md-2 pt-3">
                <button onclick="generateSalesReport()" type="button" class="btn btn-secondary">
                    <i class="bi bi-download"></i>
                </button>
            </div>
        </div>

    </form>

    <h4>SALES</h4>
    <div class="admin-content">
        <div class="d-flex align-items-center pb-2">
            <form class="form w-100 autoSubmitForm" id="searchForm" style="max-width: 500px">
                <div class="form-group d-flex align-items-center bg-dark p-2 gap-1 rounded-2">
                    <input value="{{$app->request->search}}"
                           name="search"
                           class="form-control text-white bg-transparent border-0 autoSubmitInput"
                           id="searchBox"
                           type="search"
                           style="box-shadow: none"
                           placeholder="Search Product"
                    >
                </div>
            </form>
        </div>

        <section class="d-block d-md-none">


            @forelse($items as $item)
                <div class="card mb-2">
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <span class="font-weight-bold">Product Name:</span>
                                <span class="float-right">{{$item->name}}</span>
                            </li>
                            <li class="list-group-item">
                                <span class="font-weight-bold">Remaining Products:</span>
                                <span class="float-right">{{$item->stock}}</span>
                            </li>
                            <li class="list-group-item">
                                <span class="font-weight-bold">Products Sold:</span>
                                <span class="float-right">{{$item->sold}}</span>
                            </li>
                            <li class="list-group-item">
                                <span class="font-weight-bold">Total Sales:</span>
                                <span class="float-right">{{$item->sales}}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            @empty
                <div class="d-flex align-items-center justify-content-center" style="height: 300px">
                    <h3 class="text-center text-secondary">Empty Result</h3>
                </div>
            @endforelse
        </section>


        <section class="d-none d-md-block">
            <table class="table table-bordered table-light table-hover ">
                <thead class="table-dark">
                <tr>
                    <th>Product Name</th>
                    <th>Remaining Products</th>
                    <th>Products Sold</th>
                    <th>Total Sales</th>
                </tr>
                </thead>
                <tbody>
                @forelse($items as $item)
                    <tr>
                        <td>{{$item->name}}</td>
                        <td>{{$item->stock}}</td>
                        <td>{{$item->sold}}</td>
                        <td>{{$item->sales}}</td>
                    </tr>
                @empty
                    <tr>
                        <td class="text-center" colspan="5" style="height: 300px; vertical-align: middle">Empty Result
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </section>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="reportPreviewModal" tabindex="-1" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Report Preview</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div id="reportContent" class="modal-body">
                    <h2>Sales Report</h2>
                    <div id="reportPreviewModalBody"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-bs-dismiss="modal" class="btn btn-secondary">Close</button>
                    <button type="button" onclick="downloadPdf()" class="btn btn-primary">Download</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script>

        const reportPreviewModal = new bootstrap.Modal(document.getElementById('reportPreviewModal'))
        const generateSalesReportForm = document.querySelector('#salesReportForm');
        const reportPreviewModalBody = document.querySelector('#reportPreviewModalBody');
        const reportContent = document.querySelector('#reportContent');

        async function generateSalesReport() {

            try {

                const formData = new FormData(generateSalesReportForm);

                const result = await fetch("/admin/report", {
                    method: 'POST',
                    body: formData,
                    headers: {
                        "X-CSRF-Token": "{{ csrf_token() }}"
                    }
                })

                if (!result.ok) {
                    throw new Error(data.message)
                }

                reportPreviewModalBody.innerHTML = await result.text();
                reportPreviewModal.show();

            } catch (error) {
                console.log(error)
            }
        }

        function downloadPdf() {
            var opt = {
                margin: 0,
                filename: 'report.pdf',
                image: {type: 'jpeg', quality: 0.98},
                html2canvas: {scale: 2},
                jsPDF: {unit: 'in', format: 'A4', orientation: 'portrait'}
            };

            html2pdf().set(opt).from(reportContent).save();
        }

    </script>
@endsection

