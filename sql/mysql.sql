CREATE TABLE {prefix} _{dirname} _inbox (
    `inbox_id` INT(
    8
) UNSIGNED NOT NULL AUTO_INCREMENT,
    `uid` INT (
    8
) UNSIGNED NOT NULL DEFAULT '0',
    `from_uid` INT (
    8
) UNSIGNED NOT NULL DEFAULT '0',
    `title` VARCHAR (
    100
) NOT NULL,
    `message` TEXT NOT NULL,
    `utime` INT (
    11
) UNSIGNED NOT NULL DEFAULT '0',
    `is_read` INT (
    1
) UNSIGNED NOT NULL DEFAULT '0',
    PRIMARY KEY (
    `inbox_id`
),
    KEY uid (
    `uid`
)
    ) ENGINE = ISAM;

CREATE TABLE {prefix} _{dirname} _outbox (
    `outbox_id` INT(
    8
) UNSIGNED NOT NULL AUTO_INCREMENT,
    `uid` INT (
    8
) UNSIGNED NOT NULL DEFAULT '0',
    `to_uid` INT (
    8
) UNSIGNED NOT NULL DEFAULT '0',
    `title` VARCHAR (
    100
) NOT NULL,
    `message` TEXT NOT NULL,
    `utime` INT (
    11
) UNSIGNED NOT NULL DEFAULT '0',
    PRIMARY KEY (
    `outbox_id`
),
    KEY uid (
    `uid`
)
    ) ENGINE = ISAM;
