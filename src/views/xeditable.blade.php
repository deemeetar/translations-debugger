<?php // foreach($translations as $key => $translation): ?>
<a href="#" class="edit" data-target="#<?= $group.$key ?>"><img src="/packages/deemeetar/translations-debugger/img/edit.png" alt="edit"/></a></a>
<?= $result ?>
<div id="<?= $group.$key ?>" class="dialog" title="Edit translation">
            <tr id="<?= $key ?>">
                <td><?= $key ?></td>
                <?php foreach($locales as $locale): ?>
                    <?php $t = isset($translation[$locale]) ? $translation[$locale] : null?>
                    <td>
                        <a href="#edit" class="editable status-<?= $t ? $t->status : 0 ?> locale-<?= $locale ?>" data-locale="<?= $locale ?>" data-name="<?= $locale . "|" . $key ?>" id="username" data-type="textarea" data-pk="<?= $t ? $t->id : 0 ?>" data-url="<?= $editUrl ?>" data-title="Enter translation"><?= $t ? htmlentities($t->value, ENT_QUOTES, 'UTF-8', false) : '' ?></a>
                    </td>
                <?php endforeach; ?>
                <td>
                </td>
            </tr>
</div>
<?php// endforeach; ?>