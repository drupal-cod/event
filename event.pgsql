-- Event.module SQL Definitions
-- $Id$

CREATE TABLE event (
  nid int NOT NULL default '0',
  event_start int NOT NULL default '0',
  event_end int NOT NULL default '0',
  timezone int NOT NULL default '0',
  PRIMARY KEY (nid)
);
