<!DOCTYPE html>
<html>
<head>
    <title>{{ $poll->title ?? 'Poll' }}</title>

    {{-- jQuery --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body>

<h2>{{ $poll->title ?? 'Poll' }}</h2>

{{-- POLL OPTIONS --}}
@if(isset($options) && count($options) > 0)
    <form method="POST" action="">
        @csrf

        @foreach($options as $option)
            <div>
                <label>
                    <input type="radio" name="option_id" value="{{ $option->id }}">
                    {{ $option->option_text }}
                </label>
            </div>
        @endforeach

        <br>
        <button type="submit">Vote</button>
    </form>
@else
    <p>No options available.</p>
@endif

<hr>

{{-- LIVE RESULTS --}}
<h3>Live Results</h3>
<div id="results">Loading...</div>

<script>
setInterval(function () {

    // SAFETY CHECK: poll id exists
    let pollId = "{{ $poll?->id }}";
    if (!pollId) return;

    $.get('/results/' + pollId, function (data) {
        let html = '';

        if (data.length === 0) {
            html = '<p>No votes yet.</p>';
        } else {
            data.forEach(function (row) {
                html += `<p>Option ID ${row.option_id}: ${row.total} votes</p>`;
            });
        }

        $('#results').html(html);
    });

}, 1000);
</script>

</body>
</html>
