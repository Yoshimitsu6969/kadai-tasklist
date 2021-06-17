@if (count($users) > 0)
    <ul class="list-unstyled">
        @foreach ($users as $user)
            <li class="media">

                <div class="media-body">
                    <div>
                        {{ $user->name }}
                    </div>
                    <div>
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
        {{-- ページネーションのリンク --}}
    {{ $users->links() }}

@endif