                    <div class="tab-pane fade" role="tabpanel" id="review"><br>
                        @foreach($reviews as $review)
                        <div class="row blockquote review-item"><br>
                            <div class="col-md-3 text-center">
                            <img class="rounded-circle reviewer" src="http://standaloneinstaller.com/upload/avatar.png">
                            <div class="caption">
                                <small>by <a href="#">{{$review->user->name}}</a></small>
                            </div>

                            </div>
                            <div class="col-md-9">
                            <h5>Review Produk</h5>
                            <div class="ratebox text-center" data-id="0" data-rating="5"></div>
                            <p class="review-text">{!! $review->description !!}
                                <small class="review-date">{{date('d-m-Y', strtotime($review->created_at))}}</small>
                            </div>                          
                        </div>  
                        @endforeach