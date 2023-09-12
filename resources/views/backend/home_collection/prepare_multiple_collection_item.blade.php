<div class="col-md-12 main_div_multiple mb-0">
    <div class="row">
        <div class="col-md-3 mt-1">
            <input type="file" class="form-control"  name="img_file[]" accept=".jpg,.jpeg,.png"><br/>
        </div>
        <div class="col-md-2 mt-1">
            <select class="select2"  name="img_clickable[]" style="width: 100% !important;">
                <option value = "0">No</option>
                <option value = "1">Yes</option>
            </select>
        </div>
        <div class="col-md-3 mt-1">
            <select class="select2 mapped-to"  name="mapped_to[]" style="width: 100% !important;" >
                @foreach($mappingCollectionType ?? [] as $key => $type)
                    <option value = "{{$key}}">{{ $type }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3 mt-1">
            <select class="select2  mapped-ids"  name="mapped_ids[{{$count}}][]" multiple style="width: 100% !important;" >
                @foreach($books ?? [] as $key => $book)
                    <option value="{{$book->id}}">{{$book->translations[0]->name ?? ''}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-1 mt-1">
            <a href="javascript:void(0)" class="btn btn-danger btn-sm remove-multiple-div-row"><i  class="fa fa-trash"></i></a>
        </div>
    </div>
</div>
