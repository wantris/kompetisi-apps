 {{-- Perijinan modal --}}
<div class="modal fade" id="event-add-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="border-bottom: none">
                <h5 class="modal-title" id="myLargeModalLabel"><span class="text-orange"></span></h5>
                <button type="button" class="close" data-dismiss="modal"  aria-hidden="true">×</button>
            </div>
            <div class="modal-body px-4">
                <div class="form-group mt-3">
                    <a href="{{route('ormawa.eventinternal.add')}}" class="button-choose-event">Event Internal</a>
                </div>
                <div class="form-group mt-3">
                    <a href="{{route('ormawa.eventeksternal.add')}}" class="button-choose-event">Event Eksternal</a>
                </div>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>