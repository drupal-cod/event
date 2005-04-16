-- Event.module SQL Definitions
-- $Id$

CREATE TABLE event (
  nid int NOT NULL default '0',
  start int NOT NULL default '0',
  end int NOT NULL default '0',
  tz int NOT NULL default '0',
  PRIMARY KEY (nid),
  KEY start (start)
);
