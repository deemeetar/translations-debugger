<?php // foreach($translations as $key => $translation): ?>
<a href="#" class="translation-edit" data-target="#<?= $group."_".$key ?>"><img src="/packages/deemeetar/translations-debugger/img/edit.png" alt="edit"/></a></a>
<?= $result ?>
<div id="<?= $group."_".$key ?>" class="translation-dialog" title="Edit translation for: '<?= $group.".".$key ?>'">
    <ul>
        <?php foreach($locales as $locale): ?>
            <li>
                
            <?php $t = isset($translation[$locale]) ? $translation[$locale] : null?>
            <span><?= $locale ?></span>
                <a href="#edit" class="translation-editable status-<?= $t ? $t->status : 0 ?> locale-<?= $locale ?>" data-locale="<?= $locale ?>" data-name="<?= $locale . "|" . $key ?>" id="username" data-type="textarea" data-pk="<?= $t ? $t->id : 0 ?>" data-url="<?= $editUrl ?>" data-title="Enter translation"><?= $t ? htmlentities($t->value, ENT_QUOTES, 'UTF-8', false) : '' ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
    <form class="form-inline form-publish" method="POST" action="<?= action('Barryvdh\TranslationManager\Controller@postPublish', $group) ?>" data-remote="true" role="form" data-confirm="Are you sure you want to publish the translations group '<?= $group ?>? This will overwrite existing language files.">
        <button type="submit" class="btn btn-info" data-disable-with="Publishing.." >Publish translations</button>
    </form>
    <form class="form-inline form-publish-and-refresh" method="POST" action="<?= action('Barryvdh\TranslationManager\Controller@postPublish', $group) ?>" data-remote="true" role="form" data-confirm="Are you sure you want to publish the translations group '<?= $group ?>? This will overwrite existing language files.">
        <button type="submit" class="btn btn-info" data-disable-with="Publishing.." >Publish and refresh</button>
    </form>
</div>
<?php// endforeach; ?>