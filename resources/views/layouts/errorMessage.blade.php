@if($errors->has())
    <table class="error-message">
    <tr><td>
        <span class="closebtn" onclick="$('.error-message').fadeOut(0);" style="cursor: pointer;float: right;position: absolute;right: 0%">X</span> 
    </td></tr>
    @if($errors->first() == "Error!!")
        @foreach($errors->all() as $err)
            <tr>
                <td>
                    <span style="color: red; font-size: 20px">
                        {{$err}}
                    </span>
                </td>
            </tr>
        @endforeach
    @else
        @foreach($errors->all() as $err)
            <tr>
                <td>
                    <span style="color: green; font-size: 20px">
                        {{$err}}
                    </span>
                </td>
            </tr>
        @endforeach
    @endif
    </table>
@endif