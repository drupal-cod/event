-- Event.module SQL Definitions
-- $Id$

DROP TABLE event;

CREATE TABLE event (
  nid int NOT NULL default '0',
  start int NOT NULL default '0',
  location text,
  data TEXT,
  PRIMARY KEY  (nid)
);
