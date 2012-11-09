CREATE TABLE attach (
  "id" serial,
  "pgid" int NOT NULL default '0',
  "name" varchar(255) NOT NULL default '',
  "type" varchar(255) NOT NULL default '',
  "mtime" int NOT NULL default '0',
  "size" int NOT NULL default '0',
  "mode" varchar(20) NOT NULL default '',
  "count" int NOT NULL default '0',
  "age" smallint NOT NULL default '0',
  "pass" varchar(16) NOT NULL default '',
  "freeze" smallint NOT NULL default '0',
  "copyright" smallint NOT NULL default '0',
  "owner" int NOT NULL default '0'
);

CREATE TABLE cache (
  "key" varchar(64) NOT NULL default '',
  "plugin" varchar(100) NOT NULL default '',
  "data" bytea NOT NULL,
  "mtime" int NOT NULL default '0',
  "ttl" int NOT NULL default '0'
);

CREATE TABLE count (
  "pgid" int NOT NULL default '0',
  "count" int NOT NULL default '0',
  "today" varchar(10) NOT NULL default '',
  "today_count" int NOT NULL default '0',
  "yesterday_count" int NOT NULL default '0',
  "ip" varchar(15) NOT NULL default '',
  PRIMARY KEY  (pgid)
);

CREATE TABLE pginfo (
  "pgid" serial,
  "name" varchar(255) NOT NULL default '',
  "title" varchar(255) NOT NULL default '',
  "buildtime" int NOT NULL default '0',
  "editedtime" int NOT NULL default '0',
  "uid" int NOT NULL default '0',
  "ucd" varchar(12) NOT NULL default '',
  "uname" varchar(255) NOT NULL default '',
  "freeze" smallint NOT NULL default '0',
  "einherit" smallint NOT NULL default '3',
  "eaids" text NOT NULL default '',
  "egids" varchar(255) NOT NULL default '',
  "vinherit" smallint NOT NULL default '3',
  "vaids" text NOT NULL default '',
  "vgids" varchar(255) NOT NULL default '',
  "lastuid" int NOT NULL default '0',
  "lastucd" varchar(12) NOT NULL default '',
  "lastuname" varchar(255) NOT NULL default '',
  "update" smallint NOT NULL default '0',
  "reading" varchar(255) NOT NULL default '',
  "name_ci" varchar(255) NOT NULL default '',
  "pgorder" float NOT NULL default '1',
  PRIMARY KEY  (pgid)
);

CREATE TABLE plain (
  "pgid" int NOT NULL default '0',
  "plain" text NOT NULL,
  PRIMARY KEY  (pgid)
);

CREATE TABLE rel (
  "pgid" int NOT NULL default '0',
  "relid" int NOT NULL default '0',
  PRIMARY KEY  (pgid,relid)
);

CREATE TABLE tb (
  "tbid" varchar(32) NOT NULL default '',
  "pgid" int NOT NULL default '0',
  "last_time" int NOT NULL default '0',
  "url" text NOT NULL,
  "title" varchar(255) NOT NULL default '',
  "excerpt" text NOT NULL,
  "blog_name" varchar(255) NOT NULL default '',
  "ip" varchar(15) NOT NULL default ''
);

CREATE INDEX "attach_pgid_idx" ON "attach" ("pgid");
CREATE INDEX "attach_owner_idx" ON "attach" ("owner");
CREATE INDEX "attach_name_idx" ON "attach" ("name");
CREATE INDEX "attach_type_idx" ON "attach" ("type");
CREATE INDEX "attach_mode_idx" ON "attach" ("mode");
CREATE INDEX "attach_age_idx" ON "attach" ("age");
CREATE INDEX "cache_key_idx" ON "cache" ("key");
CREATE INDEX "cache_plugin_idx" ON "cache" ("plugin");
CREATE INDEX "count_today_idx" ON "count" ("today");
CREATE INDEX "pginfo_uid_idx" ON "pginfo" ("uid");
CREATE INDEX "pginfo_name_ci_idx" ON "pginfo" ("name_ci");
CREATE INDEX "pginfo_editedtime_idx" ON "pginfo" ("editedtime");
CREATE INDEX "pginfo_freeze_idx" ON "pginfo" ("freeze");
CREATE INDEX "pginfo_egids_idx" ON "pginfo" ("egids");
CREATE INDEX "pginfo_vgids_idx" ON "pginfo" ("vgids");
CREATE INDEX "rel_pgid_idx" ON "rel" ("pgid");
CREATE INDEX "rel_relid_idx" ON "rel" ("relid");
CREATE INDEX "tb_tbid_idx" ON "tb" ("tbid");
CREATE INDEX "tb_pgid_idx" ON "tb" ("pgid");
CREATE INDEX "eaids" ON "pginfo" ("eaids");
CREATE INDEX "vaids" ON "pginfo" ("vaids");
CREATE INDEX "vids" ON "pginfo" ("vaids","vgids");
CREATE UNIQUE INDEX "id" ON "attach" ("id");
CREATE UNIQUE INDEX "name" ON "pginfo" ("name");
