<?php
    $none = true;
?>
<li class="section addons">
    <h3>Addons <a target="_top" href="<?=$repack->url()?>;edit?section=addon_management">edit</a></h3>
    <ul>
        <?php if (!empty($extensions)): ?>
            <?php $none = false; ?>
            <li class="subsection">
                <h4>Extensions</h4>
                <ul><?php foreach ($extensions as $idx=>$extension): ?>
                    <?php
                        $e = html::escape_array(array(
                            'id'        => $extension->id,
                            'version'   => $extension->version,
                            'name'      => $extension->name,
                        ));
                    ?>
                    <li>
                        <span class="name"><?=$e['name']?></span>
                        <span class="version"><?=$e['version']?></span>
                    </li>
                <?php endforeach ?></ul>
            </li>
        <?php endif ?>
        <?php if (!empty($search_plugins)): ?>
            <?php $none = false; ?>
            <li class="subsection">
                <h4>Search Plugins</h4>
                <ul><?php foreach ($search_plugins as $idx=>$plugin): ?>
                    <?php
                        $e = html::escape_array(array(
                            'name' => $plugin->ShortName,
                        ));
                    ?>
                    <li>
                        <span class="name"><?=$e['name']?></span>
                    </li>
                <?php endforeach ?></ul>
            </li>
        <?php endif ?>
        <?php if (!empty($persona)): ?>
            <?php $none = false; ?>
            <li class="subsection">
                <h4>Persona</h4>
                <ul>
                    <?php if (empty($persona)): ?>
                        <li class="empty">None.</li>
                    <?php else: ?>
                        <?php
                            $e = html::escape_array(array(
                                'name' => $persona->name,
                            ));
                        ?>
                        <li>
                            <span class="name"><?=$e['name']?></span>
                        </li>
                    <?php endif ?>
                </ul>
            </li>
        <?php endif ?>
        <?php if (!empty($theme)): ?>
            <?php $none = false; ?>
            <li class="subsection">
                <h4>Theme</h4>
                <ul>
                    <?php if (empty($theme)): ?>
                        <li class="empty">None.</li>
                    <?php else: ?>
                        <?php
                            $e = html::escape_array(array(
                                'name' => $theme->name,
                            ));
                        ?>
                        <li>
                            <span class="name"><?=$e['name']?></span>
                        </li>
                    <?php endif ?>
                </ul>
            </li>
        <?php endif ?>
        <?php if ($none): ?>
            <li class="empty">None.</li>
        <?php endif ?>
    </ul>
</li>
