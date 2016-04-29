<!-- Detached sidebar -->
<div class="sidebar-detached">
    <div class="sidebar sidebar-default">
        <div class="sidebar-content">

            <!-- Sub navigation -->
            <div class="sidebar-category">
                <div class="category-title">
                    <span>{{trans('core.sumary') }}</span>
                    <ul class="icons-list">
                        <li><a href="#" data-action="collapse"></a></li>
                    </ul>
                </div>

                <div class="category-content no-padding">
                    <ul class="navigation navigation-alt navigation-accordion">
                        @foreach($tournament->categoryTournaments as $categoryTournament)

                            <li><a href="#{{ str_slug($categoryTournament->category->buildName($grades), "-") }}"></i>
                                    <div >
                                        <?php

                                        $name = $categoryTournament->category->buildName($grades);
                                        echo str_limit($name,25);


                                        ?>

                                        <span  data-id="{{ $categoryTournament->id}}" class="menu label  label-striped">{{  sizeof($categoryTournament->users) }}</span>
                                    </div>
                                </a>

                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <!-- /sub navigation -->


        </div>
    </div>
</div>
<!-- /detached sidebar -->