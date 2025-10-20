 <div class="tab-pane fade" id="spending-section" role="tabpanel" aria-labelledby="spending-tab">
                            @if(auth()->user()->hasPermission('Expenses'))
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="fw-bold text-dark">Expenses</h5>
                                <button class="btn text-white btn-sm" style="background-color:#064e3b;" data-bs-toggle="modal" data-bs-target="#createExpenseModal">
                                    <i class="fas fa-plus me-1"></i> Add Expense
                                </button>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Item</th>
                                            <th>Amount</th>
                                            <th>Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($expenses as $expense)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $expense->item }}</td>
                                            <td>{{ number_format($expense->amount, 2) }}</td>
                                            <td>{{ $expense->date }}</td>
                                            <td>
                                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editExpenseModal-{{ $expense->id }}"><i class="fas fa-edit"></i></button>
                                                <form action="{{ route('expenses.destroy', $expense->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @endif
                        </div>