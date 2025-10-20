   <div class="tab-pane fade" id="receipts-section" role="tabpanel" aria-labelledby="receipts-tab">
                            @if(auth()->user()->hasPermission('Settings'))
                                <h5 class="fw-bold text-dark mb-3">Receipt Settings</h5>
                                <form method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label">Signature Image</label>
                                        <input type="file" name="signature" class="form-control">
                                    </div>
                                    <button type="submit" class="btn text-white" style="background-color:#064e3b;">Save Settings</button>
                                </form>
                                <hr class="my-4">
                                <h5 class="fw-bold text-dark mb-3">Receipt Preview</h5>
                                <a onclick="window.open('{{ route('receipts.printSelected') }}', '_blank')" target="_blank" class="btn btn-outline-success">
                                    View Receipt Format
                                </a>
                            @endif
                        </div>