@section('rows')
    @foreach($rows as $k => $data)
        <div class="row row-eq-height">
            <div class="col-sm-1 ranks">{{sprintf("%03d", $k+1)}}</div>
            <div class="col-sm-9 infos">
                <a href="{{$data->html_url}}" target="_blank">{{$data->title}}</a>
                <div class="pull-right text-right">
                    <span><i class="glyphicon glyphicon-comment"></i> {{sprintf("%03d", $data->comments)}}</span><br/>
                    <span title="{{$data->created_at}}"><i class="glyphicon glyphicon-calendar"></i> {{\App\Libraries\Helpers::time_elapsed_string($data->created_at)}}</span>
                </div>

            </div>
            <div class="col-sm-2 text-center votes" data-id="{{$data->id}}">
                @if(Auth::user() && \App\Models\Vote::where('github_id', $data->id)->where('user_id', Auth::user()->id)->first())
                    <span class="btnVotes" data-action="remove"><i class="glyphicon glyphicon-arrow-down"></i></span>
                @else
                    <span><i class="glyphicon glyphicon-arrow-down" style="color:lightgray"></i></span>
                @endif
                <span id="github_votes_value_{{$data->id}}">{{$data->votes}}</span>
                @if(Auth::user() && !\App\Models\Vote::where('github_id', $data->id)->where('user_id', Auth::user()->id)->first())
                    <span class="btnVotes" data-action="add"><i class="glyphicon glyphicon-arrow-up"></i></span>
                @else
                    <span><i class="glyphicon glyphicon-arrow-up" style="color:lightgray"></i></span>
                @endif
            </div>
        </div>
    @endforeach

    @if(Auth::user())
    <script>
        $("#navbar > div > span").html("Logged as: {{\Auth::user()->email}} ({{\Auth::user()->votes_count}}/{{env('VOTE_LIMIT', 10)}} votes)");
    </script>
    @endif
@show
