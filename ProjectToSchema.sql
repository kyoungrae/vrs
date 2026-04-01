--------------------------------------------------------
--  File created - Thursday-November-20-2025   
--------------------------------------------------------
--------------------------------------------------------
--  DDL for Type PLJSON
--------------------------------------------------------

  CREATE OR REPLACE EDITIONABLE TYPE "VRS"."PLJSON" force under pljson_element (

  /*
  Copyright (c) 2010 Jonas Krogsboell

  Permission is hereby granted, free of charge, to any person obtaining a copy
  of this software and associated documentation files (the "Software"), to deal
  in the Software without restriction, including without limitation the rights
  to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
  copies of the Software, and to permit persons to whom the Software is
  furnished to do so, subject to the following conditions:

  The above copyright notice and this permission notice shall be included in
  all copies or substantial portions of the Software.

  THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
  IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
  FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
  AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
  LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
  OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
  THE SOFTWARE.
  */

  /**
   * <p>This package defines <em>PL/JSON</em>'s representation of the JSON
   * object type, e.g.:</p>
   *
   * <pre>
   * {
   *   "foo": "bar",
   *   "baz": 42
   * }
   * </pre>
   *
   * <p>The primary method exported by this package is the <code>pljson</code>
   * method.</p>
   *
   * <strong>Example:</strong>
   * <pre>
   * declare
   *   myjson pljson := pljson('{ "foo": "foo", "bar": [0, 1, 2], "baz": { "foobar": "foobar" } }');
   * begin
   *   myjson.get('foo').print(); // => dbms_output.put_line('foo')
   *   myjson.get('bar[1]').print(); // => dbms_output.put_line('0')
   *   myjson.get('baz.foobar').print(); // => dbms_output.put_line('foobar')
   * end;
   * </pre>
   *
   * @headcom
   */

  /* Variables */
  /** Private variable for internal processing. */
  json_data pljson_value_array,
  /** Private variable for internal processing. */
  check_for_duplicate number,

  /* Constructors */

  /**
   * <p>Primary constructor that creates an empty object.</p>
   *
   * <p>Internally, a <code>pljson</code> "object" is an array of values.</p>
   *
   * <pre>
   *   decleare
   *     myjson pljson := pljson();
   *   begin
   *     myjson.put('foo', 'bar');
   *     dbms_output.put_line(myjson.get('foo')); // "bar"
   *   end;
   * </pre>
   *
   * @return A <code>pljson</code> instance.
   */
  constructor function pljson return self as result,

  /**
   * <p>Construct a <code>pljson</code> instance from a given string of JSON.</p>
   *
   * <pre>
   *   decleare
   *     myjson pljson := pljson('{"foo": "bar"}');
   *   begin
   *     dbms_output.put_line(myjson.get('foo')); // "bar"
   *   end;
   * </pre>
   *
   * @param str The JSON to parse into a <code>pljson</code> object.
   * @return A <code>pljson</code> instance.
   */
  constructor function pljson(str varchar2) return self as result,

  /**
   * <p>Construct a <code>pljson</code> instance from a given CLOB of JSON.</p>
   *
   * @param str The CLOB to parse into a <code>pljson</code> object.
   * @return A <code>pljson</code> instance.
   */
  constructor function pljson(str in clob) return self as result,

  /**
   * <p>Create a new <code>pljson</code> object from a current <code>pljson_value</code>.
   *
   * <pre>
   *   declare
   *    myjson pljson := pljson('{"foo": {"bar": "baz"}}');
   *    newjson pljson;
   *   begin
   *    newjson := pljson(myjson.get('foo').to_json_value())
   *   end;
   * </pre>
   *
   * @param elem The <code>pljson_value</code> to cast to a <code>pljson</code> object.
   * @return An instance of <code>pljson</code>.
   */
  constructor function pljson(elem pljson_value) return self as result,

  /**
   * <p>Create a new <code>pljson</code> object from a current <code>pljson_list</code>.
   *
   * @param l The array to create a new object from.
   * @return An instance of <code>pljson</code>.
   */
  constructor function pljson(l in out nocopy pljson_list) return self as result,

  /* Member setter methods */
  /**
   * <p>Remove a key and value from an object.</p>
   *
   * <pre>
   *   declare
   *     myjson pljson := pljson('{"foo": "foo", "bar": "bar"}')
   *   begin
   *     myjson.remove('bar'); // => '{"foo": "foo"}'
   *   end;
   * </pre>
   *
   * @param pair_name The key name to remove.
   */
  member procedure remove(pair_name varchar2),

  /**
   * <p>Add a <code>pljson</code> instance into the current instance under a
   * given key name.</p>
   *
   * @param pair_name Name of the key to add/update.
   * @param pair_value The value to associate with the key.
   */
  member procedure put(self in out nocopy pljson, pair_name varchar2, pair_value pljson_value, position pls_integer default null),

  /**
   * <p>Add a <code>varchar2</code> instance into the current instance under a
   * given key name.</p>
   *
   * @param pair_name Name of the key to add/update.
   * @param pair_value The value to associate with the key.
   */
  member procedure put(self in out nocopy pljson, pair_name varchar2, pair_value varchar2, position pls_integer default null),

  /**
   * <p>Add a <code>number</code> instance into the current instance under a
   * given key name.</p>
   *
   * @param pair_name Name of the key to add/update.
   * @param pair_value The value to associate with the key.
   */
  member procedure put(self in out nocopy pljson, pair_name varchar2, pair_value number, position pls_integer default null),

  /* E.I.Sarmas (github.com/dsnz)   2016-12-01   support for binary_double numbers */
  /**
   * <p>Add a <code>binary_double</code> instance into the current instance under a
   * given key name.</p>
   *
   * @param pair_name Name of the key to add/update.
   * @param pair_value The value to associate with the key.
   */
  member procedure put(self in out nocopy pljson, pair_name varchar2, pair_value binary_double, position pls_integer default null),

  /**
   * <p>Add a <code>boolean</code> instance into the current instance under a
   * given key name.</p>
   *
   * @param pair_name Name of the key to add/update.
   * @param pair_value The value to associate with the key.
   */
  member procedure put(self in out nocopy pljson, pair_name varchar2, pair_value boolean, position pls_integer default null),

  member procedure check_duplicate(self in out nocopy pljson, v_set boolean),
  member procedure remove_duplicates(self in out nocopy pljson),

  /*
   * had been marked as deprecated in favor of the overloaded method with pljson_value
   * the reason is unknown even though it is useful in coding
   * and removes the need for the user to do a conversion
   * also path_put function has same overloaded parameter and is not marked as deprecated
   *
   * after tests by trying to add new overloaded procedures, a theory has emerged
   * with all procedures there are cyclic type references and installation is not possible
   * so some procedures had to be removed, and these were meant to be removed
   *
   * but by careful package ordering and removing only a few procedures from pljson_list package
   * it is possible to compile the project without error and keep these procedures
   */
  member procedure put(self in out nocopy pljson, pair_name varchar2, pair_value pljson, position pls_integer default null),
  /*
   * had been marked as deprecated in favor of the overloaded method with pljson_value
   * the reason is unknown even though it is useful in coding
   * and removes the need for the user to do a conversion
   * also path_put function has same overloaded parameter and is not marked as deprecated
   *
   * after tests by trying to add new overloaded procedures, a theory has emerged
   * with all procedures there are cyclic type references and installation is not possible
   * so some procedures had to be removed, and these were meant to be removed
   *
   * but by careful package ordering and removing only a few procedures from pljson_list package
   * it is possible to compile the project without error and keep these procedures
   */
  member procedure put(self in out nocopy pljson, pair_name varchar2, pair_value pljson_list, position pls_integer default null),

  /* Member getter methods */
  /**
   * <p>Return the number values in the object. Essentially, the number of keys
   * in the object.</p>
   *
   * @return The number of values in the object.
   */
  member function count return number,

  /**
   * <p>Retrieve the value of a given key.</p>
   *
   * @param pair_name The name of the value to retrieve.
   * @return An instance of <code>pljson_value</code>, or <code>null</code>
   * if it could not be found.
   */
  member function get(pair_name varchar2) return pljson_value,

  /**
   * <p>Retrieve a value based on its position in the internal storage array.
   * It is recommended you use name based retrieval.</p>
   *
   * @param position Index of the value in the internal storage array.
   * @return An instance of <code>pljson_value</code>, or <code>null</code>
   * if it could not be found.
   */
  member function get(position pls_integer) return pljson_value,

  /**
   * <p>Determine the position of a given value within the internal storage
   * array.</p>
   *
   * @param pair_name The name of the value to retrieve the index for.
   * @return An index number, or <code>-1</code> if it could not be found.
   */
  member function index_of(pair_name varchar2) return number,

  /**
   * <p>Determine if a given value exists within the object.</p>
   *
   * @param pair_name The name of the value to check for.
   * @return <code>true</code> if the value exists, <code>false</code> otherwise.
   */
  member function exist(pair_name varchar2) return boolean,

  /* Output methods */
  /**
   * <p>Serialize the object to a JSON representation string.</p>
   *
   * @param spaces Enable pretty printing by formatting with spaces. Default: <code>true</code>.
   * @param chars_per_line Wrap output to a specific number of characters per line. Default: <code>0<code> (infinite).
   * @return A <code>varchar2</code> string.
   */
  member function to_char(spaces boolean default true, chars_per_line number default 0) return varchar2,

  /**
   * <p>Serialize the object to a JSON representation and store it in a CLOB.</p>
   *
   * @param buf The CLOB in which to store the results.
   * @param spaces Enable pretty printing by formatting with spaces. Default: <code>false</code>.
   * @param chars_per_line Wrap output to a specific number of characters per line. Default: <code>0<code> (infinite).
   * @param erase_clob Whether or not to wipe the storage CLOB prior to serialization. Default: <code>true</code>.
   * @return A <code>varchar2</code> string.
   */
  member procedure to_clob(self in pljson, buf in out nocopy clob, spaces boolean default false, chars_per_line number default 0, erase_clob boolean default true),

  /**
   * <p>Print a JSON representation of the object via <code>DBMS_OUTPUT</code>.</p>
   *
   * @param spaces Enable pretty printing by formatting with spaces. Default: <code>true</code>.
   * @param chars_per_line Wrap output to a specific number of characters per line. Default: <code>8192<code> (<code>32512</code> is maximum).
   * @param jsonp Name of a function for wrapping the output as JSONP. Default: <code>null</code>.
   * @return A <code>varchar2</code> string.
   */
  member procedure print(self in pljson, spaces boolean default true, chars_per_line number default 8192, jsonp varchar2 default null), --32512 is maximum

  /**
   * <p>Print a JSON representation of the object via <code>HTP.PRN</code>.</p>
   *
   * @param spaces Enable pretty printing by formatting with spaces. Default: <code>true</code>.
   * @param chars_per_line Wrap output to a specific number of characters per line. Default: <code>0<code> (infinite).
   * @param jsonp Name of a function for wrapping the output as JSONP. Default: <code>null</code>.
   * @return A <code>varchar2</code> string.
   */
  member procedure htp(self in pljson, spaces boolean default false, chars_per_line number default 0, jsonp varchar2 default null),

  /**
   * <p>Convert the object to a <code>pljson_value</code> for use in other methods
   * of the PL/JSON API.</p>
   *
   * @returns An instance of <code>pljson_value</code>.
   */
  member function to_json_value return pljson_value,

  /* json path */
  /**
   * <p>Retrieve a value from the internal storage array based on a path string
   * and a starting index.</p>
   *
   * @param json_path A string path, e.g. <code>'foo.bar[1]'</code>.
   * @param base The index in the internal storage array to start from.
   * This should only be necessary under special circumstances. Default: <code>1</code>.
   * @return An instance of <code>pljson_value</code>.
   */
  member function path(json_path varchar2, base number default 1) return pljson_value,

  /* json path_put */
  member procedure path_put(self in out nocopy pljson, json_path varchar2, elem pljson_value, base number default 1),
  member procedure path_put(self in out nocopy pljson, json_path varchar2, elem varchar2, base number default 1),
  member procedure path_put(self in out nocopy pljson, json_path varchar2, elem number, base number default 1),
  /* E.I.Sarmas (github.com/dsnz)   2016-12-01   support for binary_double numbers */
  member procedure path_put(self in out nocopy pljson, json_path varchar2, elem binary_double, base number default 1),
  member procedure path_put(self in out nocopy pljson, json_path varchar2, elem boolean, base number default 1),
  member procedure path_put(self in out nocopy pljson, json_path varchar2, elem pljson_list, base number default 1),
  member procedure path_put(self in out nocopy pljson, json_path varchar2, elem pljson, base number default 1),

  /* json path_remove */
  member procedure path_remove(self in out nocopy pljson, json_path varchar2, base number default 1),

  /* map functions */
  /**
   * <p>Retrieve all of the values within the object as a <code>pljson_list</code>.</p>
   *
   * <pre>
   * myjson := pljson('{"foo": "bar"}');
   * myjson.get_values(); // ['bar']
   * </pre>
   *
   * @return An instance of <code>pljson_list</code>.
   */
  member function get_values return pljson_list,

  /**
   * <p>Retrieve all of the keys within the object as a <code>pljson_list</code>.</p>
   *
   * <pre>
   * myjson := pljson('{"foo": "bar"}');
   * myjson.get_keys(); // ['foo']
   * </pre>
   *
   * @return An instance of <code>pljson_list</code>.
   */
  member function get_keys return pljson_list

) not final;
/
CREATE OR REPLACE EDITIONABLE TYPE BODY "VRS"."PLJSON" as

  /* Constructors */
  constructor function pljson return self as result as
  begin
    self.json_data := pljson_value_array();
    self.check_for_duplicate := 1;
    return;
  end;

  constructor function pljson(str varchar2) return self as result as
  begin
    self := pljson_parser.parser(str);
    self.check_for_duplicate := 1;
    return;
  end;

  constructor function pljson(str in clob) return self as result as
  begin
    self := pljson_parser.parser(str);
    self.check_for_duplicate := 1;
    return;
  end;

  constructor function pljson(elem pljson_value) return self as result as
  begin
    self := treat(elem.object_or_array as pljson);
    self.check_for_duplicate := 1;
    return;
  end;

  constructor function pljson(l in out nocopy pljson_list) return self as result as
  begin
    for i in 1 .. l.list_data.count loop
      if(l.list_data(i).mapname is null or l.list_data(i).mapname like 'row%') then
      l.list_data(i).mapname := 'row'||i;
      end if;
      l.list_data(i).mapindx := i;
    end loop;

    self.json_data := l.list_data;
    self.check_for_duplicate := 1;
    return;
  end;

  /* Member setter methods */
  member procedure remove(self in out nocopy pljson, pair_name varchar2) as
    temp pljson_value;
    indx pls_integer;

    function get_member(pair_name varchar2) return pljson_value as
      indx pls_integer;
    begin
      indx := json_data.first;
      loop
        exit when indx is null;
        if(pair_name is null and json_data(indx).mapname is null) then return json_data(indx); end if;
        if(json_data(indx).mapname = pair_name) then return json_data(indx); end if;
        indx := json_data.next(indx);
      end loop;
      return null;
    end;
  begin
    temp := get_member(pair_name);
    if(temp is null) then return; end if;

    indx := json_data.next(temp.mapindx);
    loop
      exit when indx is null;
      json_data(indx).mapindx := indx - 1;
      json_data(indx-1) := json_data(indx);
      indx := json_data.next(indx);
    end loop;
    json_data.trim(1);
    --num_elements := num_elements - 1;
  end;

  member procedure put(self in out nocopy pljson, pair_name varchar2, pair_value pljson_value, position pls_integer default null) as
    insert_value pljson_value := nvl(pair_value, pljson_value.makenull);
    indx pls_integer; x number;
    temp pljson_value;
    function get_member(pair_name varchar2) return pljson_value as
      indx pls_integer;
    begin
      indx := json_data.first;
      loop
        exit when indx is null;
        if(pair_name is null and json_data(indx).mapname is null) then return json_data(indx); end if;
        if(json_data(indx).mapname = pair_name) then return json_data(indx); end if;
        indx := json_data.next(indx);
      end loop;
      return null;
    end;
  begin
    --dbms_output.put_line('PN '||pair_name);

    --if(pair_name is null) then
    --  raise_application_error(-20102, 'JSON put-method type error: name cannot be null');
    --end if;
    insert_value.mapname := pair_name;
    --self.remove(pair_name);
    if(self.check_for_duplicate = 1) then temp := get_member(pair_name); else temp := null; end if;
    if(temp is not null) then
      insert_value.mapindx := temp.mapindx;
      json_data(temp.mapindx) := insert_value;
      return;
    elsif(position is null or position > self.count) then
      --insert at the end of the list
      --dbms_output.put_line('Test');
      --indx := self.count + 1;
      json_data.extend(1);
      /* changed to common style of updating mapindx; fix bug in assignment order */
      insert_value.mapindx := json_data.count;
      json_data(json_data.count) := insert_value;
      --dbms_output.put_line('Test2'||insert_value.mapindx);
      --dbms_output.put_line('Test2'||insert_value.mapname);
      --self.print;
    elsif(position < 2) then
      --insert at the start of the list
      indx := json_data.last;
      json_data.extend;
      loop
        exit when indx is null;
        temp := json_data(indx);
        temp.mapindx := indx+1;
        json_data(temp.mapindx) := temp;
        indx := json_data.prior(indx);
      end loop;
      /* changed to common style of updating mapindx; fix bug in assignment order */
      insert_value.mapindx := 1;
      json_data(1) := insert_value;
    else
      --insert somewhere in the list
      indx := json_data.last;
      --dbms_output.put_line('Test '||indx);
      json_data.extend;
      --dbms_output.put_line('Test '||indx);
      loop
        --dbms_output.put_line('Test '||indx);
        temp := json_data(indx);
        temp.mapindx := indx + 1;
        json_data(temp.mapindx) := temp;
        exit when indx = position;
        indx := json_data.prior(indx);
      end loop;
      /* changed to common style of updating mapindx; fix bug in assignment order */
      insert_value.mapindx := position;
      json_data(position) := insert_value;
    end if;
    --num_elements := num_elements + 1;
  end;

  member procedure put(self in out nocopy pljson, pair_name varchar2, pair_value varchar2, position pls_integer default null) as
  begin
    put(pair_name, pljson_value(pair_value), position);
  end;

  member procedure put(self in out nocopy pljson, pair_name varchar2, pair_value number, position pls_integer default null) as
  begin
    if(pair_value is null) then
      put(pair_name, pljson_value(), position);
    else
      put(pair_name, pljson_value(pair_value), position);
    end if;
  end;

  /* E.I.Sarmas (github.com/dsnz)   2016-12-01   support for binary_double numbers */
  member procedure put(self in out nocopy pljson, pair_name varchar2, pair_value binary_double, position pls_integer default null) as
  begin
    if(pair_value is null) then
      put(pair_name, pljson_value(), position);
    else
      put(pair_name, pljson_value(pair_value), position);
    end if;
  end;

  member procedure put(self in out nocopy pljson, pair_name varchar2, pair_value boolean, position pls_integer default null) as
  begin
    if(pair_value is null) then
      put(pair_name, pljson_value(), position);
    else
      put(pair_name, pljson_value(pair_value), position);
    end if;
  end;

  member procedure check_duplicate(self in out nocopy pljson, v_set boolean) as
  begin
    if(v_set) then
      check_for_duplicate := 1;
    else
      check_for_duplicate := 0;
    end if;
  end;

  /* deprecated putters */
  member procedure put(self in out nocopy pljson, pair_name varchar2, pair_value pljson, position pls_integer default null) as
  begin
    if(pair_value is null) then
      put(pair_name, pljson_value(), position);
    else
      put(pair_name, pair_value.to_json_value, position);
    end if;
  end;

  member procedure put(self in out nocopy pljson, pair_name varchar2, pair_value pljson_list, position pls_integer default null) as
  begin
    if(pair_value is null) then
      put(pair_name, pljson_value(), position);
    else
      put(pair_name, pair_value.to_json_value, position);
    end if;
  end;

  /* Member getter methods */
  member function count return number as
  begin
    return self.json_data.count;
  end;

  member function get(pair_name varchar2) return pljson_value as
    indx pls_integer;
  begin
    indx := json_data.first;
    loop
      exit when indx is null;
      if(pair_name is null and json_data(indx).mapname is null) then return json_data(indx); end if;
      if(json_data(indx).mapname = pair_name) then return json_data(indx); end if;
      indx := json_data.next(indx);
    end loop;
    return null;
  end;

  member function get(position pls_integer) return pljson_value as
  begin
    if(self.count >= position and position > 0) then
      return self.json_data(position);
    end if;
    return null; -- do not throw error, just return null
  end;

  member function index_of(pair_name varchar2) return number as
    indx pls_integer;
  begin
    indx := json_data.first;
    loop
      exit when indx is null;
      if(pair_name is null and json_data(indx).mapname is null) then return indx; end if;
      if(json_data(indx).mapname = pair_name) then return indx; end if;
      indx := json_data.next(indx);
    end loop;
    return -1;
  end;

  member function exist(pair_name varchar2) return boolean as
  begin
    return (self.get(pair_name) is not null);
  end;

  /* Output methods */
  member function to_char(spaces boolean default true, chars_per_line number default 0) return varchar2 as
  begin
    if(spaces is null) then
      return pljson_printer.pretty_print(self, line_length => chars_per_line);
    else
      return pljson_printer.pretty_print(self, spaces, line_length => chars_per_line);
    end if;
  end;

  member procedure to_clob(self in pljson, buf in out nocopy clob, spaces boolean default false, chars_per_line number default 0, erase_clob boolean default true) as
  begin
    if(spaces is null) then
      pljson_printer.pretty_print(self, false, buf, line_length => chars_per_line, erase_clob => erase_clob);
    else
      pljson_printer.pretty_print(self, spaces, buf, line_length => chars_per_line, erase_clob => erase_clob);
    end if;
  end;

  member procedure print(self in pljson, spaces boolean default true, chars_per_line number default 8192, jsonp varchar2 default null) as --32512 is the real maximum in sqldeveloper
    my_clob clob;
  begin
    my_clob := empty_clob();
    dbms_lob.createtemporary(my_clob, true);
    pljson_printer.pretty_print(self, spaces, my_clob, case when (chars_per_line>32512) then 32512 else chars_per_line end);
    pljson_printer.dbms_output_clob(my_clob, pljson_printer.newline_char, jsonp);
    dbms_lob.freetemporary(my_clob);
  end;

  member procedure htp(self in pljson, spaces boolean default false, chars_per_line number default 0, jsonp varchar2 default null) as
    my_clob clob;
  begin
    my_clob := empty_clob();
    dbms_lob.createtemporary(my_clob, true);
    pljson_printer.pretty_print(self, spaces, my_clob, chars_per_line);
    pljson_printer.htp_output_clob(my_clob, jsonp);
    dbms_lob.freetemporary(my_clob);
  end;

  member function to_json_value return pljson_value as
  begin
    return pljson_value(self);
  end;

  /* json path */
  member function path(json_path varchar2, base number default 1) return pljson_value as
  begin
    return pljson_ext.get_json_value(self, json_path, base);
  end path;

  /* json path_put */
  member procedure path_put(self in out nocopy pljson, json_path varchar2, elem pljson_value, base number default 1) as
  begin
    pljson_ext.put(self, json_path, elem, base);
  end path_put;

  member procedure path_put(self in out nocopy pljson, json_path varchar2, elem varchar2, base number default 1) as
  begin
    pljson_ext.put(self, json_path, elem, base);
  end path_put;

  member procedure path_put(self in out nocopy pljson, json_path varchar2, elem number, base number default 1) as
  begin
    if(elem is null) then
      pljson_ext.put(self, json_path, pljson_value(), base);
    else
      pljson_ext.put(self, json_path, elem, base);
    end if;
  end path_put;

  /* E.I.Sarmas (github.com/dsnz)   2016-12-01   support for binary_double numbers */
  member procedure path_put(self in out nocopy pljson, json_path varchar2, elem binary_double, base number default 1) as
  begin
    if(elem is null) then
      pljson_ext.put(self, json_path, pljson_value(), base);
    else
      pljson_ext.put(self, json_path, elem, base);
    end if;
  end path_put;

  member procedure path_put(self in out nocopy pljson, json_path varchar2, elem boolean, base number default 1) as
  begin
    if(elem is null) then
      pljson_ext.put(self, json_path, pljson_value(), base);
    else
      pljson_ext.put(self, json_path, elem, base);
    end if;
  end path_put;

  member procedure path_put(self in out nocopy pljson, json_path varchar2, elem pljson_list, base number default 1) as
  begin
    if(elem is null) then
      pljson_ext.put(self, json_path, pljson_value(), base);
    else
      pljson_ext.put(self, json_path, elem, base);
    end if;
  end path_put;

  member procedure path_put(self in out nocopy pljson, json_path varchar2, elem pljson, base number default 1) as
  begin
    if(elem is null) then
      pljson_ext.put(self, json_path, pljson_value(), base);
    else
      pljson_ext.put(self, json_path, elem, base);
    end if;
  end path_put;

  member procedure path_remove(self in out nocopy pljson, json_path varchar2, base number default 1) as
  begin
    pljson_ext.remove(self, json_path, base);
  end path_remove;

  /* Thanks to Matt Nolan */
  member function get_keys return pljson_list as
    keys pljson_list;
    indx pls_integer;
  begin
    keys := pljson_list();
    indx := json_data.first;
    loop
      exit when indx is null;
      keys.append(json_data(indx).mapname);
      indx := json_data.next(indx);
    end loop;
    return keys;
  end;

  member function get_values return pljson_list as
    vals pljson_list := pljson_list();
  begin
    vals.list_data := self.json_data;
    return vals;
  end;

  member procedure remove_duplicates(self in out nocopy pljson) as
  begin
    pljson_parser.remove_duplicates(self);
  end remove_duplicates;

end;

/
--------------------------------------------------------
--  DDL for Type PLJSON_ELEMENT
--------------------------------------------------------

  CREATE OR REPLACE EDITIONABLE TYPE "VRS"."PLJSON_ELEMENT" force as object
(
  obj_type number
)
not final;

/
--------------------------------------------------------
--  DDL for Type PLJSON_LIST
--------------------------------------------------------

  CREATE OR REPLACE EDITIONABLE TYPE "VRS"."PLJSON_LIST" force under pljson_element (

  /*
  Copyright (c) 2010 Jonas Krogsboell

  Permission is hereby granted, free of charge, to any person obtaining a copy
  of this software and associated documentation files (the "Software"), to deal
  in the Software without restriction, including without limitation the rights
  to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
  copies of the Software, and to permit persons to whom the Software is
  furnished to do so, subject to the following conditions:

  The above copyright notice and this permission notice shall be included in
  all copies or substantial portions of the Software.

  THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
  IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
  FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
  AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
  LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
  OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
  THE SOFTWARE.
  */

  /**
   * <p>This package defines <em>PL/JSON</em>'s representation of the JSON
   * array type, e.g. <code>[1, 2, "foo", "bar"]</code>.</p>
   *
   * <p>The primary method exported by this package is the <code>pljson_list</code>
   * method.</p>
   *
   * <strong>Example:</strong>
   *
   * <pre>
   * declare
   *   myarr pljson_list := pljson_list('[1, 2, "foo", "bar"]');
   * begin
   *   myarr.get(1).print(); // => dbms_output.put_line(1)
   *   myarr.get(3).print(); // => dbms_output.put_line('foo')
   * end;
   * </pre>
   *
   * @headcom
   */

  /** Private variable for internal processing. */
  list_data pljson_value_array,

  /**
   * <p>Create an empty list.</p>
   *
   * <pre>
   * declare
   *   myarr pljson_list := pljson_list();
   * begin
   *   dbms_output.put_line(myarr.count()); // => 0
   * end;
   *
   * @return An instance of <code>pljson_list</code>.
   */
  constructor function pljson_list return self as result,

  /**
   * <p>Create an instance from a given JSON array representation.</p>
   *
   * <pre>
   * declare
   *   myarr pljson_list := pljson_list('[1, 2, "foo", "bar"]');
   * begin
   *   myarr.get(1).print(); // => dbms_output.put_line(1)
   *   myarr.get(3).print(); // => dbms_output.put_line('foo')
   * end;
   * </pre>
   *
   * @param str The JSON array string to parse.
   * @return An instance of <code>pljson_list</code>.
   */
  constructor function pljson_list(str varchar2) return self as result,

  /**
   * <p>Create an instance from a given JSON array representation stored in
   * a <code>CLOB</code>.</p>
   *
   * @param str The <code>CLOB</code> to parse.
   * @return An instance of <code>pljson_list</code>.
   */
  constructor function pljson_list(str clob) return self as result,

  /**
   * <p>Create an instance from a given instance of <code>pljson_value</code>
   * that represents an array.</p>
   *
   * @param elem The <code>pljson_value</code> to cast to a <code>pljson_list</code>.
   * @return An instance of <code>pljson_list</code>.
   */
  constructor function pljson_list(elem pljson_value) return self as result,

  member procedure append(self in out nocopy pljson_list, elem pljson_value, position pls_integer default null),
  member procedure append(self in out nocopy pljson_list, elem varchar2, position pls_integer default null),
  member procedure append(self in out nocopy pljson_list, elem number, position pls_integer default null),
  /* E.I.Sarmas (github.com/dsnz)   2016-12-01   support for binary_double numbers */
  member procedure append(self in out nocopy pljson_list, elem binary_double, position pls_integer default null),
  member procedure append(self in out nocopy pljson_list, elem boolean, position pls_integer default null),
  member procedure append(self in out nocopy pljson_list, elem pljson_list, position pls_integer default null),

  member procedure replace(self in out nocopy pljson_list, position pls_integer, elem pljson_value),
  member procedure replace(self in out nocopy pljson_list, position pls_integer, elem varchar2),
  member procedure replace(self in out nocopy pljson_list, position pls_integer, elem number),
  /* E.I.Sarmas (github.com/dsnz)   2016-12-01   support for binary_double numbers */
  member procedure replace(self in out nocopy pljson_list, position pls_integer, elem binary_double),
  member procedure replace(self in out nocopy pljson_list, position pls_integer, elem boolean),
  member procedure replace(self in out nocopy pljson_list, position pls_integer, elem pljson_list),

  member function count return number,
  member procedure remove(self in out nocopy pljson_list, position pls_integer),
  member procedure remove_first(self in out nocopy pljson_list),
  member procedure remove_last(self in out nocopy pljson_list),
  member function get(position pls_integer) return pljson_value,
  member function head return pljson_value,
  member function last return pljson_value,
  member function tail return pljson_list,

  /* Output methods */
  member function to_char(spaces boolean default true, chars_per_line number default 0) return varchar2,
  member procedure to_clob(self in pljson_list, buf in out nocopy clob, spaces boolean default false, chars_per_line number default 0, erase_clob boolean default true),
  member procedure print(self in pljson_list, spaces boolean default true, chars_per_line number default 8192, jsonp varchar2 default null), --32512 is maximum
  member procedure htp(self in pljson_list, spaces boolean default false, chars_per_line number default 0, jsonp varchar2 default null),

  /* json path */
  member function path(json_path varchar2, base number default 1) return pljson_value,
  /* json path_put */
  member procedure path_put(self in out nocopy pljson_list, json_path varchar2, elem pljson_value, base number default 1),
  member procedure path_put(self in out nocopy pljson_list, json_path varchar2, elem varchar2, base number default 1),
  member procedure path_put(self in out nocopy pljson_list, json_path varchar2, elem number, base number default 1),
  /* E.I.Sarmas (github.com/dsnz)   2016-12-01   support for binary_double numbers */
  member procedure path_put(self in out nocopy pljson_list, json_path varchar2, elem binary_double, base number default 1),
  member procedure path_put(self in out nocopy pljson_list, json_path varchar2, elem boolean, base number default 1),
  member procedure path_put(self in out nocopy pljson_list, json_path varchar2, elem pljson_list, base number default 1),

  /* json path_remove */
  member procedure path_remove(self in out nocopy pljson_list, json_path varchar2, base number default 1),

  member function to_json_value return pljson_value
  /* --backwards compatibility
  member procedure add_elem(self in out nocopy json_list, elem json_value, position pls_integer default null),
  member procedure add_elem(self in out nocopy json_list, elem varchar2, position pls_integer default null),
  member procedure add_elem(self in out nocopy json_list, elem number, position pls_integer default null),
  member procedure add_elem(self in out nocopy json_list, elem boolean, position pls_integer default null),
  member procedure add_elem(self in out nocopy json_list, elem json_list, position pls_integer default null),

  member procedure set_elem(self in out nocopy json_list, position pls_integer, elem json_value),
  member procedure set_elem(self in out nocopy json_list, position pls_integer, elem varchar2),
  member procedure set_elem(self in out nocopy json_list, position pls_integer, elem number),
  member procedure set_elem(self in out nocopy json_list, position pls_integer, elem boolean),
  member procedure set_elem(self in out nocopy json_list, position pls_integer, elem json_list),

  member procedure remove_elem(self in out nocopy json_list, position pls_integer),
  member function get_elem(position pls_integer) return json_value,
  member function get_first return json_value,
  member function get_last return json_value
--*/

) not final;
/
CREATE OR REPLACE EDITIONABLE TYPE BODY "VRS"."PLJSON_LIST" as

  constructor function pljson_list return self as result as
  begin
    self.list_data := pljson_value_array();
    return;
  end;

  constructor function pljson_list(str varchar2) return self as result as
  begin
    self := pljson_parser.parse_list(str);
    return;
  end;

  constructor function pljson_list(str clob) return self as result as
  begin
    self := pljson_parser.parse_list(str);
    return;
  end;

  constructor function pljson_list(elem pljson_value) return self as result as
  begin
    self := treat(elem.object_or_array as pljson_list);
    return;
  end;


  member procedure append(self in out nocopy pljson_list, elem pljson_value, position pls_integer default null) as
    indx pls_integer;
    insert_value pljson_value := NVL(elem, pljson_value);
  begin
    if(position is null or position > self.count) then --end of list
      indx := self.count + 1;
      self.list_data.extend(1);
      self.list_data(indx) := insert_value;
    elsif(position < 1) then --new first
      indx := self.count;
      self.list_data.extend(1);
      for x in reverse 1 .. indx loop
        self.list_data(x+1) := self.list_data(x);
      end loop;
      self.list_data(1) := insert_value;
    else
      indx := self.count;
      self.list_data.extend(1);
      for x in reverse position .. indx loop
        self.list_data(x+1) := self.list_data(x);
      end loop;
      self.list_data(position) := insert_value;
    end if;

  end;

  member procedure append(self in out nocopy pljson_list, elem varchar2, position pls_integer default null) as
  begin
    append(pljson_value(elem), position);
  end;

  member procedure append(self in out nocopy pljson_list, elem number, position pls_integer default null) as
  begin
    if(elem is null) then
      append(pljson_value(), position);
    else
      append(pljson_value(elem), position);
    end if;
  end;

  /* E.I.Sarmas (github.com/dsnz)   2016-12-01   support for binary_double numbers */
  member procedure append(self in out nocopy pljson_list, elem binary_double, position pls_integer default null) as
  begin
    if(elem is null) then
      append(pljson_value(), position);
    else
      append(pljson_value(elem), position);
    end if;
  end;

  member procedure append(self in out nocopy pljson_list, elem boolean, position pls_integer default null) as
  begin
    if(elem is null) then
      append(pljson_value(), position);
    else
      append(pljson_value(elem), position);
    end if;
  end;

  member procedure append(self in out nocopy pljson_list, elem pljson_list, position pls_integer default null) as
  begin
    if(elem is null) then
      append(pljson_value(), position);
    else
      append(elem.to_json_value, position);
    end if;
  end;

  member procedure replace(self in out nocopy pljson_list, position pls_integer, elem pljson_value) as
    insert_value pljson_value := NVL(elem, pljson_value);
    indx number;
  begin
    if(position > self.count) then --end of list
      indx := self.count + 1;
      self.list_data.extend(1);
      self.list_data(indx) := insert_value;
    elsif(position < 1) then --maybe an error message here
      null;
    else
      self.list_data(position) := insert_value;
    end if;
  end;

  member procedure replace(self in out nocopy pljson_list, position pls_integer, elem varchar2) as
  begin
    replace(position, pljson_value(elem));
  end;

  member procedure replace(self in out nocopy pljson_list, position pls_integer, elem number) as
  begin
    if(elem is null) then
      replace(position, pljson_value());
    else
      replace(position, pljson_value(elem));
    end if;
  end;

  /* E.I.Sarmas (github.com/dsnz)   2016-12-01   support for binary_double numbers */
  member procedure replace(self in out nocopy pljson_list, position pls_integer, elem binary_double) as
  begin
    if(elem is null) then
      replace(position, pljson_value());
    else
      replace(position, pljson_value(elem));
    end if;
  end;

  member procedure replace(self in out nocopy pljson_list, position pls_integer, elem boolean) as
  begin
    if(elem is null) then
      replace(position, pljson_value());
    else
      replace(position, pljson_value(elem));
    end if;
  end;

  member procedure replace(self in out nocopy pljson_list, position pls_integer, elem pljson_list) as
  begin
    if(elem is null) then
      replace(position, pljson_value());
    else
      replace(position, elem.to_json_value);
    end if;
  end;

  member function count return number as
  begin
    return self.list_data.count;
  end;

  member procedure remove(self in out nocopy pljson_list, position pls_integer) as
  begin
    if(position is null or position < 1 or position > self.count) then return; end if;
    for x in (position+1) .. self.count loop
      self.list_data(x-1) := self.list_data(x);
    end loop;
    self.list_data.trim(1);
  end;

  member procedure remove_first(self in out nocopy pljson_list) as
  begin
    for x in 2 .. self.count loop
      self.list_data(x-1) := self.list_data(x);
    end loop;
    if(self.count > 0) then
      self.list_data.trim(1);
    end if;
  end;

  member procedure remove_last(self in out nocopy pljson_list) as
  begin
    if(self.count > 0) then
      self.list_data.trim(1);
    end if;
  end;

  member function get(position pls_integer) return pljson_value as
  begin
    if(self.count >= position and position > 0) then
      return self.list_data(position);
    end if;
    return null; -- do not throw error, just return null
  end;

  member function head return pljson_value as
  begin
    if(self.count > 0) then
      return self.list_data(self.list_data.first);
    end if;
    return null; -- do not throw error, just return null
  end;

  member function last return pljson_value as
  begin
    if(self.count > 0) then
      return self.list_data(self.list_data.last);
    end if;
    return null; -- do not throw error, just return null
  end;

  member function tail return pljson_list as
    t pljson_list;
  begin
    if(self.count > 0) then
      t := pljson_list(self.to_json_value);
      t.remove(1);
      return t;
    else return pljson_list(); end if;
  end;

  member function to_char(spaces boolean default true, chars_per_line number default 0) return varchar2 as
  begin
    if(spaces is null) then
      return pljson_printer.pretty_print_list(self, line_length => chars_per_line);
    else
      return pljson_printer.pretty_print_list(self, spaces, line_length => chars_per_line);
    end if;
  end;

  member procedure to_clob(self in pljson_list, buf in out nocopy clob, spaces boolean default false, chars_per_line number default 0, erase_clob boolean default true) as
  begin
    if(spaces is null) then
      pljson_printer.pretty_print_list(self, false, buf, line_length => chars_per_line, erase_clob => erase_clob);
    else
      pljson_printer.pretty_print_list(self, spaces, buf, line_length => chars_per_line, erase_clob => erase_clob);
    end if;
  end;

  member procedure print(self in pljson_list, spaces boolean default true, chars_per_line number default 8192, jsonp varchar2 default null) as --32512 is the real maximum in sqldeveloper
    my_clob clob;
  begin
    my_clob := empty_clob();
    dbms_lob.createtemporary(my_clob, true);
    pljson_printer.pretty_print_list(self, spaces, my_clob, case when (chars_per_line>32512) then 32512 else chars_per_line end);
    pljson_printer.dbms_output_clob(my_clob, pljson_printer.newline_char, jsonp);
    dbms_lob.freetemporary(my_clob);
  end;

  member procedure htp(self in pljson_list, spaces boolean default false, chars_per_line number default 0, jsonp varchar2 default null) as
    my_clob clob;
  begin
    my_clob := empty_clob();
    dbms_lob.createtemporary(my_clob, true);
    pljson_printer.pretty_print_list(self, spaces, my_clob, chars_per_line);
    pljson_printer.htp_output_clob(my_clob, jsonp);
    dbms_lob.freetemporary(my_clob);
  end;

  /* json path */
  member function path(json_path varchar2, base number default 1) return pljson_value as
    cp pljson_list := self;
  begin
    return pljson_ext.get_json_value(pljson(cp), json_path, base);
  end path;


  /* json path_put */
  member procedure path_put(self in out nocopy pljson_list, json_path varchar2, elem pljson_value, base number default 1) as
    objlist pljson;
    jp pljson_list := pljson_ext.parsePath(json_path, base);
  begin
    while(jp.head().get_number() > self.count) loop
      self.append(pljson_value());
    end loop;

    objlist := pljson(self);
    pljson_ext.put(objlist, json_path, elem, base);
    self := objlist.get_values;
  end path_put;

  member procedure path_put(self in out nocopy pljson_list, json_path varchar2, elem varchar2, base number default 1) as
    objlist pljson;
    jp pljson_list := pljson_ext.parsePath(json_path, base);
  begin
    while(jp.head().get_number() > self.count) loop
      self.append(pljson_value());
    end loop;

    objlist := pljson(self);
    pljson_ext.put(objlist, json_path, elem, base);
    self := objlist.get_values;
  end path_put;

  member procedure path_put(self in out nocopy pljson_list, json_path varchar2, elem number, base number default 1) as
    objlist pljson;
    jp pljson_list := pljson_ext.parsePath(json_path, base);
  begin
    while(jp.head().get_number() > self.count) loop
      self.append(pljson_value());
    end loop;

    objlist := pljson(self);

    if(elem is null) then
      pljson_ext.put(objlist, json_path, pljson_value, base);
    else
      pljson_ext.put(objlist, json_path, elem, base);
    end if;
    self := objlist.get_values;
  end path_put;

  /* E.I.Sarmas (github.com/dsnz)   2016-12-01   support for binary_double numbers */
  member procedure path_put(self in out nocopy pljson_list, json_path varchar2, elem binary_double, base number default 1) as
    objlist pljson;
    jp pljson_list := pljson_ext.parsePath(json_path, base);
  begin
    while(jp.head().get_number() > self.count) loop
      self.append(pljson_value());
    end loop;

    objlist := pljson(self);

    if(elem is null) then
      pljson_ext.put(objlist, json_path, pljson_value, base);
    else
      pljson_ext.put(objlist, json_path, elem, base);
    end if;
    self := objlist.get_values;
  end path_put;

  member procedure path_put(self in out nocopy pljson_list, json_path varchar2, elem boolean, base number default 1) as
    objlist pljson;
    jp pljson_list := pljson_ext.parsePath(json_path, base);
  begin
    while(jp.head().get_number() > self.count) loop
      self.append(pljson_value());
    end loop;

    objlist := pljson(self);
    if(elem is null) then
      pljson_ext.put(objlist, json_path, pljson_value, base);
    else
      pljson_ext.put(objlist, json_path, elem, base);
    end if;
    self := objlist.get_values;
  end path_put;

  member procedure path_put(self in out nocopy pljson_list, json_path varchar2, elem pljson_list, base number default 1) as
    objlist pljson;
    jp pljson_list := pljson_ext.parsePath(json_path, base);
  begin
    while(jp.head().get_number() > self.count) loop
      self.append(pljson_value());
    end loop;

    objlist := pljson(self);
    if(elem is null) then
      pljson_ext.put(objlist, json_path, pljson_value, base);
    else
      pljson_ext.put(objlist, json_path, elem, base);
    end if;
    self := objlist.get_values;
  end path_put;

  /* json path_remove */
  member procedure path_remove(self in out nocopy pljson_list, json_path varchar2, base number default 1) as
    objlist pljson := pljson(self);
  begin
    pljson_ext.remove(objlist, json_path, base);
    self := objlist.get_values;
  end path_remove;


  member function to_json_value return pljson_value as
  begin
    return pljson_value(self);
  end;

  /* --backwards compatibility
  member procedure add_elem(self in out nocopy json_list, elem json_value, position pls_integer default null) as begin append(elem,position); end;
  member procedure add_elem(self in out nocopy json_list, elem varchar2, position pls_integer default null) as begin append(elem,position); end;
  member procedure add_elem(self in out nocopy json_list, elem number, position pls_integer default null) as begin append(elem,position); end;
  member procedure add_elem(self in out nocopy json_list, elem boolean, position pls_integer default null) as begin append(elem,position); end;
  member procedure add_elem(self in out nocopy json_list, elem json_list, position pls_integer default null) as begin append(elem,position); end;

  member procedure set_elem(self in out nocopy json_list, position pls_integer, elem json_value) as begin replace(position,elem); end;
  member procedure set_elem(self in out nocopy json_list, position pls_integer, elem varchar2) as begin replace(position,elem); end;
  member procedure set_elem(self in out nocopy json_list, position pls_integer, elem number) as begin replace(position,elem); end;
  member procedure set_elem(self in out nocopy json_list, position pls_integer, elem boolean) as begin replace(position,elem); end;
  member procedure set_elem(self in out nocopy json_list, position pls_integer, elem json_list) as begin replace(position,elem); end;

  member procedure remove_elem(self in out nocopy json_list, position pls_integer) as begin remove(position); end;
  member function get_elem(position pls_integer) return json_value as begin return get(position); end;
  member function get_first return json_value as begin return head(); end;
  member function get_last return json_value as begin return last(); end;
--*/

end;

/
--------------------------------------------------------
--  DDL for Type PLJSON_NARRAY
--------------------------------------------------------

  CREATE OR REPLACE EDITIONABLE TYPE "VRS"."PLJSON_NARRAY" as table of number;

/
--------------------------------------------------------
--  DDL for Type PLJSON_TABLE_IMPL
--------------------------------------------------------

  CREATE OR REPLACE EDITIONABLE TYPE "VRS"."PLJSON_TABLE_IMPL" as object (

  /*
  Copyright (c) 2016 E.I.Sarmas (github.com/dsnz)

  Permission is hereby granted, free of charge, to any person obtaining a copy
  of this software and associated documentation files (the "Software"), to deal
  in the Software without restriction, including without limitation the rights
  to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
  copies of the Software, and to permit persons to whom the Software is
  furnished to do so, subject to the following conditions:

  The above copyright notice and this permission notice shall be included in
  all copies or substantial portions of the Software.

  THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
  IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
  FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
  AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
  LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
  OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
  THE SOFTWARE.
  */

  /*
    E.I.Sarmas (github.com/dsnz)   2016-02-09   first version

    E.I.Sarmas (github.com/dsnz)   2017-07-21   minor update, better parameter names
    E.I.Sarmas (github.com/dsnz)   2017-09-23   major update, table_mode = cartessian/nested
  */



  /*
  drop type pljson_table_impl;
  drop type pljson_narray;
  drop type pljson_vtab;
  drop type pljson_varray;

  create or replace type pljson_varray as table of varchar2(32767);
  create or replace type pljson_vtab as table of pljson_varray;
  create or replace type pljson_narray as table of number;

  create synonym pljson_table for pljson_table_impl;
  */

  str clob, -- varchar2(32767),
  /*
    for 'nested' mode paths must use the [*] path operator
  */
  column_paths pljson_varray,
  column_names pljson_varray,
  table_mode varchar2(20),

  /*
    'cartessian' mode uses only
    data_tab, row_ind
  */
  data_tab pljson_vtab,
  /*
    'nested' mode uses only
    row_ind, row_count, nested_path
    column_nested_index
    last_nested_index

    for row_ind, row_count, nested_path
    each entry corresponds to a [*] in the full path of the last column
    and there will be the same or fewer entries than columns
    1st nested path corresponds to whole array as '[*]'
    or to root object as '' or to array within root object as 'key1.key2...array[*]'

    column_nested_index maps column index to nested_... index
  */
  row_ind pljson_narray,
  row_count pljson_narray,
  /*
    nested_path_full = full path, up to and including last [*], but not dot notation to key
    nested_path_ext = extension to previous nested path
    column_path_part = extension to nested_path_full, the dot notation to key after last [*]
    column_path = nested_path_full || column_path_part

    start_column = start column where nested path appears first
    nested_path_literal = nested_path_full with * replaced with literal integers, for fetching

    column_path = a[*].b.c[*].e
    nested_path_full = a[*].b.c[*]
    nested_path_ext = .b.c[*]
    column_path_part = .e
  */
  nested_path_full pljson_varray,
  nested_path_ext pljson_varray,
  start_column pljson_narray,
  nested_path_literal pljson_varray,

  column_nested_index pljson_narray,
  column_path_part pljson_varray,
  column_val pljson_varray,

  /* if the root of the document is array, the size of the array */
  root_array_size number,

  /* the parsed json_obj */
  json_obj pljson,

  ret_type anytype,

  static function ODCITableDescribe(
    rtype out anytype,
    json_str clob, column_paths pljson_varray, column_names pljson_varray := null,
    table_mode varchar2 := 'cartessian'
  ) return number,

  static function ODCITablePrepare(
    sctx out pljson_table_impl,
    ti in sys.ODCITabFuncInfo,
    json_str clob, column_paths pljson_varray, column_names pljson_varray := null,
    table_mode varchar2 := 'cartessian'
  ) return number,

  static function ODCITableStart(
    sctx in out pljson_table_impl,
    json_str clob, column_paths pljson_varray, column_names pljson_varray := null,
    table_mode varchar2 := 'cartessian'
  ) return number,

  member function ODCITableFetch(
    self in out pljson_table_impl, nrows in number, outset out anydataset
  ) return number,

  member function ODCITableClose(self in pljson_table_impl) return number,

  static function json_table(
    json_str clob, column_paths pljson_varray, column_names pljson_varray := null,
    table_mode varchar2 := 'cartessian'
  ) return anydataset
  pipelined using pljson_table_impl
);
/
CREATE OR REPLACE EDITIONABLE TYPE BODY "VRS"."PLJSON_TABLE_IMPL" as

  /*
  Copyright (c) 2016 E.I.Sarmas (github.com/dsnz)

  Permission is hereby granted, free of charge, to any person obtaining a copy
  of this software and associated documentation files (the "Software"), to deal
  in the Software without restriction, including without limitation the rights
  to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
  copies of the Software, and to permit persons to whom the Software is
  furnished to do so, subject to the following conditions:

  The above copyright notice and this permission notice shall be included in
  all copies or substantial portions of the Software.

  THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
  IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
  FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
  AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
  LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
  OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
  THE SOFTWARE.
  */

  /*
    E.I.Sarmas (github.com/dsnz)   2016-02-09   first version

    E.I.Sarmas (github.com/dsnz)   2017-07-21   minor update, better parameter names
    E.I.Sarmas (github.com/dsnz)   2017-09-23   major update, table_mode = cartessian/nested
  */

  static function ODCITableDescribe(
    rtype out anytype,
    json_str clob, column_paths pljson_varray, column_names pljson_varray := null,
    table_mode varchar2 := 'cartessian'
  ) return number is
    atyp anytype;
  begin
    --dbms_output.put_line('>>Describe');

    anytype.begincreate(dbms_types.typecode_object, atyp);
    if column_names is null then
      for i in column_paths.FIRST .. column_paths.LAST loop
        atyp.addattr('JSON_' || ltrim(to_char(i)), dbms_types.typecode_varchar2, null, null, 32767, null, null);
      end loop;
    else
      for i in column_names.FIRST .. column_names.LAST loop
        atyp.addattr(upper(column_names(i)), dbms_types.typecode_varchar2, null, null, 32767, null, null);
      end loop;
    end if;
    atyp.endcreate;

    anytype.begincreate(dbms_types.typecode_table, rtype);
    rtype.SetInfo(null, null, null, null, null, atyp, dbms_types.typecode_object, 0);
    rtype.endcreate();

    --dbms_output.put_line('>>Describe end');
    return odciconst.success;
  exception
    when others then
      return odciconst.error;
  end;

  static function ODCITablePrepare(
    sctx out pljson_table_impl,
    ti in sys.ODCITabFuncInfo,
    json_str clob, column_paths pljson_varray, column_names pljson_varray := null,
    table_mode varchar2 := 'cartessian'
  ) return number is
    elem_typ sys.anytype;
    prec  pls_integer;
    scale pls_integer;
    len   pls_integer;
    csid  pls_integer;
    csfrm pls_integer;
    tc    pls_integer;
    aname varchar2(30);
  begin
    --dbms_output.put_line('>>Prepare');

    tc := ti.RetType.GetAttrElemInfo(1, prec, scale, len, csid, csfrm, elem_typ, aname);
    sctx := pljson_table_impl(
      json_str, column_paths, column_names,
      table_mode,
      pljson_vtab(), pljson_narray(), pljson_narray(),
      pljson_varray(), pljson_varray(),  pljson_narray(), pljson_varray(),
      pljson_narray(), pljson_varray(), pljson_varray(),
      0,
      pljson(),
      elem_typ
    );
    return odciconst.success;
  end;

  -- E.I.Sarmas (github.com/dsnz)   2017-09-23   NEW support for nested/cartessian table generation
  static function ODCITableStart(
    sctx in out pljson_table_impl,
    json_str clob, column_paths pljson_varray, column_names pljson_varray := null,
    table_mode varchar2 := 'cartessian'
  ) return number is
    json_obj pljson;
    json_val pljson_value;
    buf varchar2(32767);
    --data_tab pljson_vtab := pljson_vtab();
    json_arr pljson_list;
    json_elem pljson_value;
    value_array pljson_varray := pljson_varray();

    -- E.I.Sarmas (github.com/dsnz)   2017-09-23   NEW support for array as root json data
    root_val pljson_value;
    root_list pljson_list;
    root_array_size number := 0;
    /* for nested mode */
    last_nested_path_full varchar2(32767);
    column_path varchar(32767);
    array_pos number;
    nested_path_prefix varchar2(32767);
    nested_path_ext varchar2(32767);
    column_path_part varchar2(32767);
    /* a starts with b */
    function starts_with(a in varchar2, b in varchar2) return boolean is
    begin
      if b is null then
        return True;
      end if;
      if substr(a, 1, length(b)) = b then
        return True;
      end if;
      return False;
    end;
  begin
    --dbms_output.put_line('>>Start');

    --dbms_output.put_line('json_str='||json_str);
    -- json_obj := pljson(json_str);
    root_val := pljson_parser.parse_any(json_str);
    --dbms_output.put_line('parsed: ' || root_val.get_type);
    if root_val.typeval = 2 then
      root_list := pljson_list(root_val);
      root_array_size := root_list.count;
      json_obj := pljson(root_list);
    else
      -- implicit root of size 1
      root_array_size := 1;
      json_obj := pljson(root_val);
    end if;
    --dbms_output.put_line('... array size = ' || root_array_size);

    sctx.json_obj := json_obj;
    sctx.table_mode := table_mode;
    sctx.root_array_size := root_array_size;
    sctx.data_tab.delete;

    if table_mode = 'cartessian' then
      for i in column_paths.FIRST .. column_paths.LAST loop
        --dbms_output.put_line('path='||column_paths(i));
        json_val := pljson_ext.get_json_value(json_obj, column_paths(i));
        --dbms_output.put_line('type='||json_val.get_type());
        case json_val.typeval
          --when 1 then 'object';
          when 2 then -- 'array';
            json_arr := pljson_list(json_val);
            value_array.delete;
            for j in 1 .. json_arr.count loop
              json_elem := json_arr.get(j);
              case json_elem.typeval
                --when 1 then 'object';
                --when 2 then -- 'array';
                when 3 then -- 'string';
                  buf := json_elem.get_string();
                  --dbms_output.put_line('res[](string)='||buf);
                  value_array.extend(); value_array(value_array.LAST) := buf;
                when 4 then -- 'number';
                  buf := to_char(json_elem.get_number());
                  --dbms_output.put_line('res[](number)='||buf);
                  value_array.extend(); value_array(value_array.LAST) := buf;
                when 5 then -- 'bool';
                  buf := case json_elem.get_bool() when true then 'true' when false then 'false' end;
                  --dbms_output.put_line('res[](bool)='||buf);
                  value_array.extend(); value_array(value_array.LAST) := buf;
                when 6 then -- 'null';
                  buf := null;
                  --dbms_output.put_line('res[](null)='||buf);
                  value_array.extend(); value_array(value_array.LAST) := buf;
                else
                  -- if object is unknown or does not exist add new element of type null
                  buf := null;
                  --dbms_output.put_line('res[](unknown)='||buf);
                  sctx.data_tab.extend(); sctx.data_tab(sctx.data_tab.LAST) := pljson_varray(buf);
              end case;
            end loop;
            sctx.data_tab.extend(); sctx.data_tab(sctx.data_tab.LAST) := value_array;
          when 3 then -- 'string';
            buf := json_val.get_string();
            --dbms_output.put_line('res(string)='||buf);
            sctx.data_tab.extend(); sctx.data_tab(sctx.data_tab.LAST) := pljson_varray(buf);
          when 4 then -- 'number';
            buf := to_char(json_val.get_number());
            --dbms_output.put_line('res(number)='||buf);
            sctx.data_tab.extend(); sctx.data_tab(sctx.data_tab.LAST) := pljson_varray(buf);
          when 5 then -- 'bool';
            buf := case json_val.get_bool() when true then 'true' when false then 'false' end;
            --dbms_output.put_line('res(bool)='||buf);
            sctx.data_tab.extend(); sctx.data_tab(sctx.data_tab.LAST) := pljson_varray(buf);
          when 6 then -- 'null';
            buf := null;
            --dbms_output.put_line('res(null)='||buf);
            sctx.data_tab.extend(); sctx.data_tab(sctx.data_tab.LAST) := pljson_varray(buf);
          else
            -- if object is unknown or does not exist add new element of type null
            buf := null;
            --dbms_output.put_line('res(unknown)='||buf);
            sctx.data_tab.extend(); sctx.data_tab(sctx.data_tab.LAST) := pljson_varray(buf);
        end case;
      end loop;

      --dbms_output.put_line('initialize row indexes');
      sctx.row_ind.delete;
      --for i in data_tab.FIRST .. data_tab.LAST loop
      for i in column_paths.FIRST .. column_paths.LAST loop
        sctx.row_ind.extend();
        sctx.row_ind(sctx.row_ind.LAST) := 1;
      end loop;
    else
      /* setup nested mode */
      sctx.nested_path_full.delete;
      sctx.nested_path_ext.delete;
      sctx.column_path_part.delete;
      sctx.column_nested_index.delete;
      for i in column_paths.FIRST .. column_paths.LAST loop
        --dbms_output.put_line(i || ', column_path = ' || column_paths(i));
        column_path := column_paths(i);
        array_pos := instr(column_path, '[*]', -1);
        if array_pos > 0 then
          nested_path_prefix := substr(column_path, 1, array_pos+2);
        else
          nested_path_prefix := '';
        end if;
        --dbms_output.put_line(i || ', nested_path_prefix = ' || nested_path_prefix);
        last_nested_path_full := '';
        if sctx.nested_path_full.LAST is not null then
          last_nested_path_full := sctx.nested_path_full(sctx.nested_path_full.LAST);
        end if;
        --dbms_output.put_line(i || ', last_nested_path_full = ' || last_nested_path_full);
        if not starts_with(nested_path_prefix, last_nested_path_full) then
          --dbms_output.put_line('column paths are not nested, column# ' || i);
          raise_application_error(-20120, 'column paths are not nested, column# ' || i);
        end if;
        if i = 1 or nested_path_prefix != last_nested_path_full
        or (nested_path_prefix is not null and last_nested_path_full is null) then
          nested_path_ext := substr(nested_path_prefix, nvl(length(last_nested_path_full), 0)+1);
          if instr(nested_path_ext, '[*]') != instr(nested_path_ext, '[*]', -1) then
            --dbms_output.put_line('column introduces more than one array, column# ' || i);
            raise_application_error(-20120, 'column introduces more than one array, column# ' || i);
          end if;
          sctx.nested_path_full.extend();
          sctx.nested_path_full(sctx.nested_path_full.LAST) := nested_path_prefix;
          --dbms_output.put_line(i || ', new nested_path_full = ' || nested_path_prefix);
          sctx.nested_path_ext.extend();
          sctx.nested_path_ext(sctx.nested_path_ext.LAST) := nested_path_ext;
          --dbms_output.put_line(i || ', new nested_path_ext = ' || nested_path_ext);
          sctx.start_column.extend();
          sctx.start_column(sctx.start_column.LAST) := i;
        end if;
        sctx.column_nested_index.extend();
        sctx.column_nested_index(sctx.column_nested_index.LAST) := sctx.nested_path_full.LAST;
        --dbms_output.put_line(i || ', column_nested_index = ' || sctx.nested_path_full.LAST);
        column_path_part := substr(column_path, nvl(length(nested_path_prefix), 0)+1);
        sctx.column_path_part.extend();
        sctx.column_path_part(sctx.column_path_part.LAST) := column_path_part;
        --dbms_output.put_line(i || ', column_path_part = ' || column_path_part);
      end loop;
      --dbms_output.put_line('initialize row indexes');
      sctx.row_ind.delete;
      sctx.row_count.delete;
      sctx.nested_path_literal.delete;
      sctx.column_val.delete;
      if sctx.nested_path_full.LAST is not null then
        for i in 1 .. sctx.nested_path_full.LAST loop
          sctx.row_ind.extend();
          sctx.row_ind(sctx.row_ind.LAST) := -1;
          sctx.row_count.extend();
          sctx.row_count(sctx.row_count.LAST) := -1;
          sctx.nested_path_literal.extend();
          sctx.nested_path_literal(sctx.nested_path_literal.LAST) := '';
        end loop;
      end if;
      for i in 1 .. sctx.column_paths.LAST loop
        sctx.column_val.extend();
        sctx.column_val(sctx.column_val.LAST) := '';
      end loop;
    end if;

    return odciconst.success;
  end;

  member function ODCITableFetch(
    self in out pljson_table_impl, nrows in number, outset out anydataset
  ) return number is
    --data_row pljson_varray := pljson_varray();
    --type index_array is table of number;
    --row_ind index_array := index_array();
    j number;
    num_rows number := 0;

    --json_obj pljson;
    json_val pljson_value;
    buf varchar2(32767);
    --data_tab pljson_vtab := pljson_vtab();
    json_arr pljson_list;
    json_elem pljson_value;
    value_array pljson_varray := pljson_varray();

    /* nested mode */
    temp_path varchar(32767);
    start_index number;
    k number;
    /*
      k is nested path index and not column index
      sets row_count()
    */
    procedure set_count(k number) is
      temp_path varchar(32767);
    begin
      if k = 1 then
        if nested_path_full(1) is null or nested_path_full(1) = '[*]' then
          row_count(1) := root_array_size;
          return;
        else
          temp_path := substr(nested_path_full(1), 1, length(nested_path_full(1)) - 3);
        end if;
      else
        temp_path := nested_path_literal(k - 1) || substr(nested_path_ext(k), 1, length(nested_path_ext(k)) - 3);
      end if;
      --dbms_output.put_line(k || ', set_count temp_path = ' || temp_path);
      json_val := pljson_ext.get_json_value(json_obj, temp_path);
      if json_val.typeval != 2 then
        raise_application_error(-20120, 'column introduces array with [*] but is not array in json, column# ' || k);
      end if;
      row_count(k) := pljson_list(json_val).count;
    end;
    /*
      k is nested path index and not column index
      sets nested_path_literal() for row_ind(k)
    */
    procedure set_nested_path_literal(k number) is
      temp_path varchar(32767);
    begin
      if k = 1 then
        if nested_path_full(1) is null then
          return;
        end if;
        temp_path := substr(nested_path_full(1), 1, length(nested_path_full(1)) - 2);
      else
        temp_path := nested_path_literal(k - 1) || substr(nested_path_ext(k), 1, length(nested_path_ext(k)) - 2);
      end if;
      nested_path_literal(k) := temp_path || row_ind(k) || ']';
    end;
  begin
    --dbms_output.put_line('>>Fetch, nrows = ' || nrows);

    if table_mode = 'cartessian' then
      outset := null;

      if row_ind(1) = 0 then
        --dbms_output.put_line('>>Fetch End');
        return odciconst.success;
      end if;

      anydataset.begincreate(dbms_types.typecode_object, self.ret_type, outset);

      /* iterative cartesian product algorithm */
      <<main_loop>>
      while True loop
        exit when num_rows = nrows or row_ind(1) = 0;
        --data_row.delete;
        outset.addinstance;
        outset.piecewise();
        --dbms_output.put_line('put one row piece');
        for i in data_tab.FIRST .. data_tab.LAST loop
          --data_row.extend();
          --data_row(data_row.LAST) := data_tab(i)(row_ind(i));
          --dbms_output.put_line('json_'||ltrim(to_char(i)));
          --dbms_output.put_line('['||ltrim(to_char(row_ind(i)))||']');
          --dbms_output.put_line('='||data_tab(i)(row_ind(i)));
          outset.setvarchar2(data_tab(i)(row_ind(i)));
        end loop;
        --pipe row(data_row);
        num_rows := num_rows + 1;

        --dbms_output.put_line('adjust row indexes');
        j := row_ind.COUNT;
        <<index_loop>>
        while True loop
          row_ind(j) := row_ind(j) + 1;
          if row_ind(j) <= data_tab(j).COUNT then
            exit index_loop;
          end if;
          row_ind(j) := 1;
          j := j - 1;
          if j < 1 then
            row_ind(1) := 0; -- hack to indicate end of all fetches
            exit main_loop;
          end if;
        end loop index_loop;
      end loop main_loop;

      outset.endcreate;
      --dbms_output.put_line('>>Fetch Complete, rows = ' || num_rows || ', row_ind(1) = ' || row_ind(1));
    else
      /* fetch nested mode */
      outset := null;

      anydataset.begincreate(dbms_types.typecode_object, self.ret_type, outset);

      <<main_loop_nested>>
      while True loop
        /* find starting column */
        /*
          in first run, loop will not assign value to start_index, so start_index := 0
          in last run after all rows produced, the same will happen and start_index := 0
          but the last run will have row_count(1) >= 0
        */
        start_index := 0;
        for i in REVERSE row_ind.FIRST .. row_ind.LAST loop
          if row_ind(i) < row_count(i) then
            start_index := start_column(i);
            exit;
          end if;
        end loop;
        if start_index = 0 then
          if num_rows = nrows or row_count(1) >= 0 then
            --dbms_output.put_line('>>Fetch End');
            exit main_loop_nested;
          else
            start_index := 1;
          end if;
        end if;

        /* fetch rows */
        --dbms_output.put_line('fetch new row, start from column# '|| start_index);
        <<row_loop_nested>>
        for i in start_index .. column_paths.LAST loop
          k := column_nested_index(i);
          /* new nested path */
          if start_column(k) = i then
            --dbms_output.put_line(i || ', new nested path');
            /* new count */
            if row_ind(k) = row_count(k) then
              set_count(k);
              row_ind(k) := 0;
              --dbms_output.put_line(i || ', new nested count = ' || row_count(k));
            end if;
            /* advance row_ind */
            row_ind(k) := row_ind(k) + 1;
            set_nested_path_literal(k);
          end if;
          temp_path := nested_path_literal(k) || column_path_part(i);
          --dbms_output.put_line(i || ', path = ' || temp_path);
          json_val := pljson_ext.get_json_value(json_obj, temp_path);
          --dbms_output.put_line('type='||json_val.get_type());
          case json_val.typeval
            --when 1 then 'object';
            --when 2 then -- 'array';
            when 3 then -- 'string';
              buf := json_val.get_string();
              --dbms_output.put_line('res(string)='||buf);
              column_val(i) := buf;
            when 4 then -- 'number';
              buf := to_char(json_val.get_number());
              --dbms_output.put_line('res(number)='||buf);
              column_val(i) := buf;
            when 5 then -- 'bool';
              buf := case json_val.get_bool() when true then 'true' when false then 'false' end;
              --dbms_output.put_line('res(bool)='||buf);
              column_val(i) := buf;
            when 6 then -- 'null';
              buf := null;
              --dbms_output.put_line('res(null)='||buf);
              column_val(i) := buf;
            else
              -- if object is unknown or does not exist add new element of type null
              buf := null;
              --dbms_output.put_line('res(unknown)='||buf);
              column_val(i) := buf;
          end case;
          if i = column_paths.LAST then
            outset.addinstance;
            outset.piecewise();
            for j in column_val.FIRST .. column_val.LAST loop
              outset.setvarchar2(column_val(j));
            end loop;
            num_rows := num_rows + 1;
          end if;
        end loop row_loop_nested;
      end loop main_loop_nested;

      outset.endcreate;
      --dbms_output.put_line('>>Fetch Complete, rows = ' || num_rows);
    end if;

    return odciconst.success;
  end;

  member function ODCITableClose(self in pljson_table_impl) return number is
  begin
    --dbms_output.put_line('>>Close');
    return odciconst.success;
  end;

end;

/
--------------------------------------------------------
--  DDL for Type PLJSON_VALUE
--------------------------------------------------------

  CREATE OR REPLACE EDITIONABLE TYPE "VRS"."PLJSON_VALUE" force as object (

  /*
  Copyright (c) 2010 Jonas Krogsboell

  Permission is hereby granted, free of charge, to any person obtaining a copy
  of this software and associated documentation files (the "Software"), to deal
  in the Software without restriction, including without limitation the rights
  to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
  copies of the Software, and to permit persons to whom the Software is
  furnished to do so, subject to the following conditions:

  The above copyright notice and this permission notice shall be included in
  all copies or substantial portions of the Software.

  THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
  IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
  FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
  AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
  LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
  OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
  THE SOFTWARE.
  */

  /**
   * <p>Underlying type for all of <em>PL/JSON</em>. Each <code>pljson</code>
   * or <code>pljson_list</code> object is composed of
   * <code>pljson_value</code> objects.</p>
   *
   * <p>Generally, you should not need to directly use the constructors provided
   * by this portion of the API. The methods on <code>pljson</code> and
   * <code>pljson_list</code> should be used instead.</p>
   *
   * @headcom
   */

  /**
   * <p>Internal property that indicates the JSON type represented:<p>
   * <ol>
   *   <li><code>object</code></li>
   *   <li><code>array</code></li>
   *   <li><code>string</code></li>
   *   <li><code>number</code></li>
   *   <li><code>bool</code></li>
   *   <li><code>null</code></li>
   * </ol>
   */
  typeval number(1), /* 1 = object, 2 = array, 3 = string, 4 = number, 5 = bool, 6 = null */
  /** Private variable for internal processing. */
  str varchar2(32767),
  /** Private variable for internal processing. */
  num number, /* store 1 as true, 0 as false */
  /** Private variable for internal processing. */
  num_double binary_double, -- both num and num_double are set, there is never exception (until Oracle 12c)
  /** Private variable for internal processing. */
  num_repr_number_p varchar2(1),
  /** Private variable for internal processing. */
  num_repr_double_p varchar2(1),
  /** Private variable for internal processing. */
  object_or_array pljson_element, /* object or array in here */
  /** Private variable for internal processing. */
  extended_str clob,

  /* mapping */
  /** Private variable for internal processing. */
  mapname varchar2(4000),
  /** Private variable for internal processing. */
  mapindx number(32),

  constructor function pljson_value(elem pljson_element) return self as result,
  constructor function pljson_value(str varchar2, esc boolean default true) return self as result,
  constructor function pljson_value(str clob, esc boolean default true) return self as result,
  constructor function pljson_value(num number) return self as result,
  /* E.I.Sarmas (github.com/dsnz)   2016-11-03   support for binary_double numbers */
  constructor function pljson_value(num_double binary_double) return self as result,
  constructor function pljson_value(b boolean) return self as result,
  constructor function pljson_value return self as result,

  member function get_element return pljson_element,

  /**
   * <p>Create an empty <code>pljson_value</code>.</p>
   *
   * <pre>
   * declare
   *   myval pljson_value := pljson_value.makenull();
   * begin
   *   myval.parse_number('42');
   *   myval.print(); // => dbms_output.put_line('42');
   * end;
   * </pre>
   *
   * @return An instance of <code>pljson_value</code>.
   */
  static function makenull return pljson_value,

  /**
   * <p>Retrieve the name of the type represented by the <code>pljson_value</code>.</p>
   * <p>Possible return values:</p>
   * <ul>
   *   <li><code>object</code></li>
   *   <li><code>array</code></li>
   *   <li><code>string</code></li>
   *   <li><code>number</code></li>
   *   <li><code>bool</code></li>
   *   <li><code>null</code></li>
   * </ul>
   *
   * @return The name of the type represented.
   */
  member function get_type return varchar2,

  /**
   * <p>Retrieve the value as a string (<code>varchar2</code>).</p>
   *
   * @param max_byte_size Retreive the value up to a specific number of bytes. Default: <code>null</code>.
   * @param max_char_size Retrieve the value up to a specific number of characters. Default: <code>null</code>.
   * @return An instance of <code>varchar2</code> or <code>null</code> value is not a string.
   */
  member function get_string(max_byte_size number default null, max_char_size number default null) return varchar2,

  /**
   * <p>Retrieve the value as a string represented by a <code>CLOB</code>.</p>
   *
   * @param buf The <code>CLOB</code> in which to store the string.
   */
  member procedure get_string(self in pljson_value, buf in out nocopy clob),

  /**
   * <p>Retrieve the value as a <code>number</code>.</p>
   *
   * @return An instance of <code>number</code> or <code>null</code> if the value isn't a number.
   */
  member function get_number return number,

  /* E.I.Sarmas (github.com/dsnz)   2016-11-03   support for binary_double numbers */
  /**
   * <p>Retrieve the value as a <code>binary_double</code>.</p>
   *
   * @return An instance of <code>binary_double</code> or <code>null</code> if the value isn't a number.
   */
  member function get_double return binary_double,

  /**
   * <p>Retrieve the value as a <code>boolean</code>.</p>
   *
   * @return An instance of <code>boolean</code> or <code>null</code> if the value isn't a boolean.
   */
  member function get_bool return boolean,

  /**
   * <p>Retrieve the value as a string <code>'null'<code>.</p>
   *
   * @return A <code>varchar2</code> with the value <code>'null'</code> or
   * an actual <code>null</code> if the value isn't a JSON "null".
   */
  member function get_null return varchar2,

  /**
   * <p>Determine if the value represents an "object" type.</p>
   *
   * @return <code>true</code> if the value is an object, <code>false</code> otherwise.
   */
  member function is_object return boolean,

  /**
   * <p>Determine if the value represents an "array" type.</p>
   *
   * @return <code>true</code> if the value is an array, <code>false</code> otherwise.
   */
  member function is_array return boolean,

  /**
   * <p>Determine if the value represents a "string" type.</p>
   *
   * @return <code>true</code> if the value is a string, <code>false</code> otherwise.
   */
  member function is_string return boolean,

  /**
   * <p>Determine if the value represents a "number" type.</p>
   *
   * @return <code>true</code> if the value is a number, <code>false</code> otherwise.
   */
  member function is_number return boolean,

  /**
   * <p>Determine if the value represents a "boolean" type.</p>
   *
   * @return <code>true</code> if the value is a boolean, <code>false</code> otherwise.
   */
  member function is_bool return boolean,

  /**
   * <p>Determine if the value represents a "null" type.</p>
   *
   * @return <code>true</code> if the value is a null, <code>false</code> otherwise.
   */
  member function is_null return boolean,

  /* E.I.Sarmas (github.com/dsnz)   2016-11-03   support for binary_double numbers, is_number is still true, extra info */
  /* return true if 'number' is representable by number */
  /** Private method for internal processing. */
  member function is_number_repr_number return boolean,
  /* return true if 'number' is representable by binary_double */
  /** Private method for internal processing. */
  member function is_number_repr_double return boolean,

  /* E.I.Sarmas (github.com/dsnz)   2016-11-03   support for binary_double numbers */
  -- set value for number from string representation; to replace to_number in pljson_parser
  -- can automatically decide and use binary_double if needed
  -- less confusing than new constructor with dummy argument for overloading
  -- centralized parse_number to use everywhere else and replace code in pljson_parser
  /**
   * <p>Parses a string into a number. This method will automatically cast to
   * a <code>binary_double</code> if it is necessary.</p>
   *
   * <pre>
   * declare
   *   mynum pljson_value := pljson_value('42');
   * begin
   *   dbms_output.put_line('mynum is a string: ' || mynum.is_string()); // 'true'
   *   mynum.parse_number('42');
   *   dbms_output.put_line('mynum is a number: ' || mynum.is_number()); // 'true'
   * end;
   * </pre>
   *
   * @param str A <code>varchar2</code> to parse into a number.
   */
  member procedure parse_number(str varchar2),

  /* E.I.Sarmas (github.com/dsnz)   2016-12-01   support for binary_double numbers */
  /**
   * <p>Return a <code>varchar2</code> representation of a <code>number</code>
   * type. This is primarily intended to be used within PL/JSON internally.</p>
   *
   * @return A <code>varchar2</code> up to 4000 characters.
   */
  member function number_toString return varchar2,

  /* Output methods */
  member function to_char(spaces boolean default true, chars_per_line number default 0) return varchar2,
  member procedure to_clob(self in pljson_value, buf in out nocopy clob, spaces boolean default false, chars_per_line number default 0, erase_clob boolean default true),
  member procedure print(self in pljson_value, spaces boolean default true, chars_per_line number default 8192, jsonp varchar2 default null), --32512 is maximum
  member procedure htp(self in pljson_value, spaces boolean default false, chars_per_line number default 0, jsonp varchar2 default null),

  member function value_of(self in pljson_value, max_byte_size number default null, max_char_size number default null) return varchar2

) not final;
/
CREATE OR REPLACE EDITIONABLE TYPE BODY "VRS"."PLJSON_VALUE" as

  constructor function pljson_value(elem pljson_element) return self as result as
  begin
    case
      when elem is of (pljson)      then self.typeval := 1;
      when elem is of (pljson_list) then self.typeval := 2;
      else raise_application_error(-20102, 'PLJSON_VALUE init error (PLJSON or PLJSON_LIST allowed)');
    end case;
    self.object_or_array := elem;
    if(self.object_or_array is null) then self.typeval := 6; end if;

    return;
  end pljson_value;

  constructor function pljson_value(str varchar2, esc boolean default true) return self as result as
  begin
    self.typeval := 3;
    if(esc) then self.num := 1; else self.num := 0; end if; --message to pretty printer
    self.str := str;
    return;
  end pljson_value;

  constructor function pljson_value(str clob, esc boolean default true) return self as result as
    /* E.I.Sarmas (github.com/dsnz)   2016-01-21   limit to 5000 chars */
    amount number := 5000; /* for Unicode text, varchar2 'self.str' not exceed 5000 chars, does not limit size of data */
  begin
    self.typeval := 3;
    if(esc) then self.num := 1; else self.num := 0; end if; --message to pretty printer
    if(dbms_lob.getlength(str) > amount) then
      extended_str := str;
    end if;
    -- GHS 20120615: Added IF structure to handle null clobs
    if dbms_lob.getlength(str) > 0 then
      dbms_lob.read(str, amount, 1, self.str);
    end if;
    return;
  end pljson_value;

  constructor function pljson_value(num number) return self as result as
  begin
    self.typeval := 4;
    self.num := num;
    /* E.I.Sarmas (github.com/dsnz)   2016-11-03   support for binary_double numbers; typeval not changed, it is still json number */
    self.num_repr_number_p := 't';
    self.num_double := num;
    if (to_number(self.num_double) = self.num) then
      self.num_repr_double_p := 't';
    else
      self.num_repr_double_p := 'f';
    end if;
    /* */
    if(self.num is null) then self.typeval := 6; end if;
    return;
  end pljson_value;

  /* E.I.Sarmas (github.com/dsnz)   2016-11-03   support for binary_double numbers; typeval not changed, it is still json number */
  constructor function pljson_value(num_double binary_double) return self as result as
  begin
    self.typeval := 4;
    self.num_double := num_double;
    self.num_repr_double_p := 't';
    self.num := num_double;
    if (to_binary_double(self.num) = self.num_double) then
      self.num_repr_number_p := 't';
    else
      self.num_repr_number_p := 'f';
    end if;
    if(self.num_double is null) then self.typeval := 6; end if;
    return;
  end pljson_value;

  constructor function pljson_value(b boolean) return self as result as
  begin
    self.typeval := 5;
    self.num := 0;
    if(b) then self.num := 1; end if;
    if(b is null) then self.typeval := 6; end if;
    return;
  end pljson_value;

  constructor function pljson_value return self as result as
  begin
    self.typeval := 6; /* for JSON null */
    return;
  end pljson_value;

  member function get_element return pljson_element as
  begin
    if (self.typeval in (1,2)) then
      return self.object_or_array;
    end if;
    return null;
  end get_element;

  static function makenull return pljson_value as
  begin
    return pljson_value;
  end makenull;

  member function get_type return varchar2 as
  begin
    case self.typeval
    when 1 then return 'object';
    when 2 then return 'array';
    when 3 then return 'string';
    when 4 then return 'number';
    when 5 then return 'bool';
    when 6 then return 'null';
    end case;

    return 'unknown type';
  end get_type;

  member function get_string(max_byte_size number default null, max_char_size number default null) return varchar2 as
  begin
    if(self.typeval = 3) then
      if(max_byte_size is not null) then
        return substrb(self.str,1,max_byte_size);
      elsif (max_char_size is not null) then
        return substr(self.str,1,max_char_size);
      else
        return self.str;
      end if;
    end if;
    return null;
  end get_string;

  member procedure get_string(self in pljson_value, buf in out nocopy clob) as
  begin
    if(self.typeval = 3) then
      if(extended_str is not null) then
        dbms_lob.copy(buf, extended_str, dbms_lob.getlength(extended_str));
      else
        dbms_lob.writeappend(buf, length(self.str), self.str);
      end if;
    end if;
  end get_string;

  member function get_number return number as
  begin
    if(self.typeval = 4) then
      return self.num;
    end if;
    return null;
  end get_number;

  /* E.I.Sarmas (github.com/dsnz)   2016-11-03   support for binary_double numbers */
  member function get_double return binary_double as
  begin
    if(self.typeval = 4) then
      return self.num_double;
    end if;
    return null;
  end get_double;

  member function get_bool return boolean as
  begin
    if(self.typeval = 5) then
      return self.num = 1;
    end if;
    return null;
  end get_bool;

  member function get_null return varchar2 as
  begin
    if(self.typeval = 6) then
      return 'null';
    end if;
    return null;
  end get_null;

  member function is_object return boolean as begin return self.typeval = 1; end;
  member function is_array return boolean as begin return self.typeval = 2; end;
  member function is_string return boolean as begin return self.typeval = 3; end;
  member function is_number return boolean as begin return self.typeval = 4; end;
  member function is_bool return boolean as begin return self.typeval = 5; end;
  member function is_null return boolean as begin return self.typeval = 6; end;

  /* E.I.Sarmas (github.com/dsnz)   2016-11-03   support for binary_double numbers, is_number is still true, extra check */
  /* return true if 'number' is representable by number */
  member function is_number_repr_number return boolean is
  begin
    if self.typeval != 4 then
      return false;
    end if;
    return (num_repr_number_p = 't');
  end;

  /* return true if 'number' is representable by binary_double */
  member function is_number_repr_double return boolean is
  begin
    if self.typeval != 4 then
      return false;
    end if;
    return (num_repr_double_p = 't');
  end;

  /* E.I.Sarmas (github.com/dsnz)   2016-11-03   support for binary_double numbers */
  -- set value for number from string representation; to replace to_number in pljson_parser
  -- can automatically decide and use binary_double if needed (set repr variables)
  -- underflows and overflows count as representable if happen on both type representations
  -- less confusing than new constructor with dummy argument for overloading
  -- centralized parse_number to use everywhere else and replace code in pljson_parser
  member procedure parse_number(str varchar2) is
  begin
    if self.typeval != 4 then
      return;
    end if;
    self.num := to_number(str);
    self.num_repr_number_p := 't';
    self.num_double := to_binary_double(str);
    self.num_repr_double_p := 't';
    if (to_binary_double(self.num) != self.num_double) then
      self.num_repr_number_p := 'f';
    end if;
    if (to_number(self.num_double) != self.num) then
      self.num_repr_double_p := 'f';
    end if;
  end parse_number;

  /* E.I.Sarmas (github.com/dsnz)   2016-12-01   support for binary_double numbers */
  -- centralized toString to use everywhere else and replace code in pljson_printer
  member function number_toString return varchar2 is
    num number;
    num_double binary_double;
    buf varchar2(4000);
  begin
    /* unrolled, instead of using two nested fuctions for speed */
    if (self.num_repr_number_p = 't') then
      num := self.num;
      if (num > 1e127d) then
        return '1e309'; -- json representation of infinity !?
      end if;
      if (num < -1e127d) then
        return '-1e309'; -- json representation of infinity !?
      end if;
      buf := STANDARD.to_char(num, 'TM9', 'NLS_NUMERIC_CHARACTERS=''.,''');
      if (-1 < num and num < 0 and substr(buf, 1, 2) = '-.') then
        buf := '-0' || substr(buf, 2);
      elsif (0 < num and num < 1 and substr(buf, 1, 1) = '.') then
        buf := '0' || buf;
      end if;
      return buf;
    else
      num_double := self.num_double;
      if (num_double = +BINARY_DOUBLE_INFINITY) then
        return '1e309'; -- json representation of infinity !?
      end if;
      if (num_double = -BINARY_DOUBLE_INFINITY) then
        return '-1e309'; -- json representation of infinity !?
      end if;
      buf := STANDARD.to_char(num_double, 'TM9', 'NLS_NUMERIC_CHARACTERS=''.,''');
      if (-1 < num_double and num_double < 0 and substr(buf, 1, 2) = '-.') then
        buf := '-0' || substr(buf, 2);
      elsif (0 < num_double and num_double < 1 and substr(buf, 1, 1) = '.') then
        buf := '0' || buf;
      end if;
      return buf;
    end if;
  end number_toString;

  /* Output methods */
  member function to_char(spaces boolean default true, chars_per_line number default 0) return varchar2 as
  begin
    if(spaces is null) then
      return pljson_printer.pretty_print_any(self, line_length => chars_per_line);
    else
      return pljson_printer.pretty_print_any(self, spaces, line_length => chars_per_line);
    end if;
  end;

  member procedure to_clob(self in pljson_value, buf in out nocopy clob, spaces boolean default false, chars_per_line number default 0, erase_clob boolean default true) as
  begin
    if(spaces is null) then
      pljson_printer.pretty_print_any(self, false, buf, line_length => chars_per_line, erase_clob => erase_clob);
    else
      pljson_printer.pretty_print_any(self, spaces, buf, line_length => chars_per_line, erase_clob => erase_clob);
    end if;
  end;

  member procedure print(self in pljson_value, spaces boolean default true, chars_per_line number default 8192, jsonp varchar2 default null) as --32512 is the real maximum in sqldeveloper
    my_clob clob;
  begin
    my_clob := empty_clob();
    dbms_lob.createtemporary(my_clob, true);
    pljson_printer.pretty_print_any(self, spaces, my_clob, case when (chars_per_line>32512) then 32512 else chars_per_line end);
    pljson_printer.dbms_output_clob(my_clob, pljson_printer.newline_char, jsonp);
    dbms_lob.freetemporary(my_clob);
  end;

  member procedure htp(self in pljson_value, spaces boolean default false, chars_per_line number default 0, jsonp varchar2 default null) as
    my_clob clob;
  begin
    my_clob := empty_clob();
    dbms_lob.createtemporary(my_clob, true);
    pljson_printer.pretty_print_any(self, spaces, my_clob, chars_per_line);
    pljson_printer.htp_output_clob(my_clob, jsonp);
    dbms_lob.freetemporary(my_clob);
  end;

  member function value_of(self in pljson_value, max_byte_size number default null, max_char_size number default null) return varchar2 as
  begin
    case self.typeval
    when 1 then return 'json object';
    when 2 then return 'json array';
    when 3 then return self.get_string(max_byte_size, max_char_size);
    when 4 then return self.get_number();
    when 5 then if(self.get_bool()) then return 'true'; else return 'false'; end if;
    else return null;
    end case;
  end;

end;

/
--------------------------------------------------------
--  DDL for Type PLJSON_VALUE_ARRAY
--------------------------------------------------------

  CREATE OR REPLACE EDITIONABLE TYPE "VRS"."PLJSON_VALUE_ARRAY" as table of pljson_value;

/
--------------------------------------------------------
--  DDL for Type PLJSON_VARRAY
--------------------------------------------------------

  CREATE OR REPLACE EDITIONABLE TYPE "VRS"."PLJSON_VARRAY" as table of varchar2(32767);

/
--------------------------------------------------------
--  DDL for Type PLJSON_VTAB
--------------------------------------------------------

  CREATE OR REPLACE EDITIONABLE TYPE "VRS"."PLJSON_VTAB" as table of pljson_varray;

/
--------------------------------------------------------
--  DDL for Sequence ADDRESS_MICRODISTRICT_SEQ
--------------------------------------------------------

   CREATE SEQUENCE  "VRS"."ADDRESS_MICRODISTRICT_SEQ"  MINVALUE 1 MAXVALUE 9999999999999999999999999999 INCREMENT BY 1 START WITH 2401 CACHE 20 NOORDER  NOCYCLE  NOKEEP  NOSCALE  GLOBAL ;
--------------------------------------------------------
--  DDL for Sequence ADDRESS_SUBDEV_UNIT_SEQ
--------------------------------------------------------

   CREATE SEQUENCE  "VRS"."ADDRESS_SUBDEV_UNIT_SEQ"  MINVALUE 1 MAXVALUE 9999999999999999999999999999 INCREMENT BY 1 START WITH 10476 CACHE 20 NOORDER  NOCYCLE  NOKEEP  NOSCALE  GLOBAL ;
--------------------------------------------------------
--  DDL for Sequence ARCHIVE_NUMBER_SEQ
--------------------------------------------------------

   CREATE SEQUENCE  "VRS"."ARCHIVE_NUMBER_SEQ"  MINVALUE 1 MAXVALUE 9999999999999999999999999999 INCREMENT BY 1 START WITH 3634 CACHE 20 NOORDER  NOCYCLE  NOKEEP  NOSCALE  GLOBAL ;
--------------------------------------------------------
--  DDL for Sequence EPAY_TRANSACTION_SEQ
--------------------------------------------------------

   CREATE SEQUENCE  "VRS"."EPAY_TRANSACTION_SEQ"  MINVALUE 1 MAXVALUE 9999999999999999999999999999 INCREMENT BY 1 START WITH 3417145 CACHE 20 NOORDER  NOCYCLE  NOKEEP  NOSCALE  GLOBAL ;
--------------------------------------------------------
--  DDL for Sequence HIBERNATE_SEQUENCE
--------------------------------------------------------

   CREATE SEQUENCE  "VRS"."HIBERNATE_SEQUENCE"  MINVALUE 1 MAXVALUE 9999999999999999999999999999 INCREMENT BY 20000000 START WITH 11824860181017 CACHE 20 NOORDER  NOCYCLE  NOKEEP  NOSCALE  GLOBAL ;
--------------------------------------------------------
--  DDL for Sequence LOG_UPDATED_SEQ
--------------------------------------------------------

   CREATE SEQUENCE  "VRS"."LOG_UPDATED_SEQ"  MINVALUE 1 MAXVALUE 9999999999999999999999999999 INCREMENT BY 1 START WITH 281021 CACHE 20 NOORDER  NOCYCLE  NOKEEP  NOSCALE  GLOBAL ;
--------------------------------------------------------
--  DDL for Sequence MAIN_REF_GENDER_SEQ
--------------------------------------------------------

   CREATE SEQUENCE  "VRS"."MAIN_REF_GENDER_SEQ"  MINVALUE 1 MAXVALUE 9999999999999999999999999999 INCREMENT BY 1 START WITH 21 CACHE 20 NOORDER  NOCYCLE  NOKEEP  NOSCALE  GLOBAL ;
--------------------------------------------------------
--  DDL for Sequence MAIN_USER_MENU_SEQ
--------------------------------------------------------

   CREATE SEQUENCE  "VRS"."MAIN_USER_MENU_SEQ"  MINVALUE 1 MAXVALUE 9999999999999999999999999999 INCREMENT BY 1 START WITH 1 CACHE 20 NOORDER  NOCYCLE  NOKEEP  NOSCALE  GLOBAL ;
--------------------------------------------------------
--  DDL for Sequence MAIN_USER_POSITION_MENU_SEQ
--------------------------------------------------------

   CREATE SEQUENCE  "VRS"."MAIN_USER_POSITION_MENU_SEQ"  MINVALUE 1 MAXVALUE 9999999999999999999999999999 INCREMENT BY 1 START WITH 1 CACHE 20 NOORDER  NOCYCLE  NOKEEP  NOSCALE  GLOBAL ;
--------------------------------------------------------
--  DDL for Sequence MIGRATIONS_ID_SEQ
--------------------------------------------------------

   CREATE SEQUENCE  "VRS"."MIGRATIONS_ID_SEQ"  MINVALUE 1 MAXVALUE 9999999999999999999999999999 INCREMENT BY 1 START WITH 21 CACHE 20 NOORDER  NOCYCLE  NOKEEP  NOSCALE  GLOBAL ;
--------------------------------------------------------
--  DDL for Sequence MIGRATIONS_SEQ
--------------------------------------------------------

   CREATE SEQUENCE  "VRS"."MIGRATIONS_SEQ"  MINVALUE 1 MAXVALUE 9999999999999999999999999999 INCREMENT BY 1 START WITH 114 CACHE 20 NOORDER  NOCYCLE  NOKEEP  NOSCALE  GLOBAL ;
--------------------------------------------------------
--  DDL for Sequence OWNER_SEQ
--------------------------------------------------------

   CREATE SEQUENCE  "VRS"."OWNER_SEQ"  MINVALUE 1 MAXVALUE 9999999999999999999999999999 INCREMENT BY 1 START WITH 1397022 CACHE 20 NOORDER  NOCYCLE  NOKEEP  NOSCALE  GLOBAL ;
  GRANT SELECT ON "VRS"."OWNER_SEQ" TO "USER_EMONGOL";
--------------------------------------------------------
--  DDL for Sequence PKID
--------------------------------------------------------

   CREATE SEQUENCE  "VRS"."PKID"  MINVALUE 1 MAXVALUE 9999999999999999999999999999 INCREMENT BY 1 START WITH 100 CACHE 20 NOORDER  NOCYCLE  NOKEEP  NOSCALE  GLOBAL ;
--------------------------------------------------------
--  DDL for Sequence REF_ENGINE_MODEL_SEQ
--------------------------------------------------------

   CREATE SEQUENCE  "VRS"."REF_ENGINE_MODEL_SEQ"  MINVALUE 1 MAXVALUE 9999999999999999999999999999 INCREMENT BY 1 START WITH 1 CACHE 20 NOORDER  NOCYCLE  NOKEEP  NOSCALE  GLOBAL ;
--------------------------------------------------------
--  DDL for Sequence REF_REFERENCE_ORG_SEQ
--------------------------------------------------------

   CREATE SEQUENCE  "VRS"."REF_REFERENCE_ORG_SEQ"  MINVALUE 1 MAXVALUE 9999999999999999999999999999 INCREMENT BY 1 START WITH 324 CACHE 20 NOORDER  NOCYCLE  NOKEEP  NOSCALE  GLOBAL ;
--------------------------------------------------------
--  DDL for Sequence REG_CERTIFICATE_SEQ
--------------------------------------------------------

   CREATE SEQUENCE  "VRS"."REG_CERTIFICATE_SEQ"  MINVALUE 1 MAXVALUE 9999999999999999999999999999 INCREMENT BY 1 START WITH 4315441 CACHE 20 NOORDER  NOCYCLE  NOKEEP  NOSCALE  GLOBAL ;
--------------------------------------------------------
--  DDL for Sequence REG_LIMITED_SEQ
--------------------------------------------------------

   CREATE SEQUENCE  "VRS"."REG_LIMITED_SEQ"  MINVALUE 1 MAXVALUE 9999999999999999999999999999 INCREMENT BY 1 START WITH 126381 CACHE 20 NOORDER  NOCYCLE  NOKEEP  NOSCALE  GLOBAL ;
--------------------------------------------------------
--  DDL for Sequence REG_MARK_SEQ
--------------------------------------------------------

   CREATE SEQUENCE  "VRS"."REG_MARK_SEQ"  MINVALUE 1 MAXVALUE 9999999999999999999999999999 INCREMENT BY 1 START WITH 420 CACHE 20 NOORDER  NOCYCLE  NOKEEP  NOSCALE  GLOBAL ;
--------------------------------------------------------
--  DDL for Sequence REG_MODEL_SEQ
--------------------------------------------------------

   CREATE SEQUENCE  "VRS"."REG_MODEL_SEQ"  MINVALUE 1 MAXVALUE 9999999999999999999999999999 INCREMENT BY 1 START WITH 26256 CACHE 20 NOORDER  NOCYCLE  NOKEEP  NOSCALE  GLOBAL ;
--------------------------------------------------------
--  DDL for Sequence REG_PLATENUMBER_SAVE_ORDER_SEQ
--------------------------------------------------------

   CREATE SEQUENCE  "VRS"."REG_PLATENUMBER_SAVE_ORDER_SEQ"  MINVALUE 1 MAXVALUE 9999999999999999999999999999 INCREMENT BY 1 START WITH 159534 CACHE 20 NOORDER  NOCYCLE  NOKEEP  NOSCALE  GLOBAL ;
--------------------------------------------------------
--  DDL for Sequence REG_REFERENCE_LOG_SEQ
--------------------------------------------------------

   CREATE SEQUENCE  "VRS"."REG_REFERENCE_LOG_SEQ"  MINVALUE 1 MAXVALUE 9999999999999999999999999999 INCREMENT BY 1 START WITH 48374 CACHE 20 NOORDER  NOCYCLE  NOKEEP  NOSCALE  GLOBAL ;
--------------------------------------------------------
--  DDL for Sequence REG_RFID_TAG_SEQ
--------------------------------------------------------

   CREATE SEQUENCE  "VRS"."REG_RFID_TAG_SEQ"  MINVALUE 1 MAXVALUE 9999999999999999999999999999 INCREMENT BY 1 START WITH 1088221 CACHE 20 NOORDER  NOCYCLE  NOKEEP  NOSCALE  GLOBAL ;
--------------------------------------------------------
--  DDL for Sequence REG_STATUS_SEQ
--------------------------------------------------------

   CREATE SEQUENCE  "VRS"."REG_STATUS_SEQ"  MINVALUE 1 MAXVALUE 9999999999999999999999999999 INCREMENT BY 1 START WITH 24 CACHE 20 NOORDER  NOCYCLE  NOKEEP  NOSCALE  GLOBAL ;
--------------------------------------------------------
--  DDL for Sequence REG_VEHICLE_ARCHIVE_ID_ASQ
--------------------------------------------------------

   CREATE SEQUENCE  "VRS"."REG_VEHICLE_ARCHIVE_ID_ASQ"  MINVALUE 0 MAXVALUE 9999999999999999999999999999 INCREMENT BY 1 START WITH 15636739 CACHE 20 NOORDER  NOCYCLE  NOKEEP  NOSCALE  GLOBAL ;
--------------------------------------------------------
--  DDL for Sequence REG_VEHICLE_ARCHIVE_SEQ
--------------------------------------------------------

   CREATE SEQUENCE  "VRS"."REG_VEHICLE_ARCHIVE_SEQ"  MINVALUE 1 MAXVALUE 9999999999999999999999999999 INCREMENT BY 1 START WITH 15636099 CACHE 20 NOORDER  NOCYCLE  NOKEEP  NOSCALE  GLOBAL ;
--------------------------------------------------------
--  DDL for Sequence REG_VEHICLE_OWNERSHIP_SEQ
--------------------------------------------------------

   CREATE SEQUENCE  "VRS"."REG_VEHICLE_OWNERSHIP_SEQ"  MINVALUE 1 MAXVALUE 9999999999999999999999999999 INCREMENT BY 1 START WITH 6617091 CACHE 20 NOORDER  NOCYCLE  NOKEEP  NOSCALE  GLOBAL ;
--------------------------------------------------------
--  DDL for Sequence REG_VEHICLE_SEQ
--------------------------------------------------------

   CREATE SEQUENCE  "VRS"."REG_VEHICLE_SEQ"  MINVALUE 1 MAXVALUE 9999999999999999999999999999 INCREMENT BY 1 START WITH 1621268 CACHE 20 NOORDER  NOCYCLE  NOKEEP  NOSCALE  GLOBAL ;
--------------------------------------------------------
--  DDL for Sequence SEQ_REF_COLOR
--------------------------------------------------------

   CREATE SEQUENCE  "VRS"."SEQ_REF_COLOR"  MINVALUE 1 MAXVALUE 9999999999999999999999999999 INCREMENT BY 1 START WITH 216 NOCACHE  NOORDER  NOCYCLE  NOKEEP  NOSCALE  GLOBAL ;
--------------------------------------------------------
--  DDL for Sequence SEQ_REF_COUNTRY
--------------------------------------------------------

   CREATE SEQUENCE  "VRS"."SEQ_REF_COUNTRY"  MINVALUE 1 MAXVALUE 9999999999999999999999999999 INCREMENT BY 1 START WITH 269 NOCACHE  NOORDER  NOCYCLE  NOKEEP  NOSCALE  GLOBAL ;
  GRANT SELECT ON "VRS"."SEQ_REF_COUNTRY" TO "MVIS";
--------------------------------------------------------
--  DDL for Sequence SEQ_REF_ENGINE_MODEL
--------------------------------------------------------

   CREATE SEQUENCE  "VRS"."SEQ_REF_ENGINE_MODEL"  MINVALUE 1 MAXVALUE 9999999999999999999999999999 INCREMENT BY 1 START WITH 8436 NOCACHE  NOORDER  NOCYCLE  NOKEEP  NOSCALE  GLOBAL ;
  GRANT SELECT ON "VRS"."SEQ_REF_ENGINE_MODEL" TO "MVIS";
--------------------------------------------------------
--  DDL for Sequence SEQ_REF_GENERAL
--------------------------------------------------------

   CREATE SEQUENCE  "VRS"."SEQ_REF_GENERAL"  MINVALUE 1 MAXVALUE 9999999999999999999999999999 INCREMENT BY 1 START WITH 197 NOCACHE  NOORDER  NOCYCLE  NOKEEP  NOSCALE  GLOBAL ;
--------------------------------------------------------
--  DDL for Sequence SEQ_REF_GENERAL_TYPE
--------------------------------------------------------

   CREATE SEQUENCE  "VRS"."SEQ_REF_GENERAL_TYPE"  MINVALUE 1 MAXVALUE 9999999999999999999999999999 INCREMENT BY 1 START WITH 1 NOCACHE  NOORDER  NOCYCLE  NOKEEP  NOSCALE  GLOBAL ;
  GRANT SELECT ON "VRS"."SEQ_REF_GENERAL_TYPE" TO "MVIS";
--------------------------------------------------------
--  DDL for Sequence SEQ_REF_PURPOSE
--------------------------------------------------------

   CREATE SEQUENCE  "VRS"."SEQ_REF_PURPOSE"  MINVALUE 1 MAXVALUE 9999999999999999999999999999 INCREMENT BY 1 START WITH 2 NOCACHE  NOORDER  NOCYCLE  NOKEEP  NOSCALE  GLOBAL ;
  GRANT SELECT ON "VRS"."SEQ_REF_PURPOSE" TO "MVIS";
--------------------------------------------------------
--  DDL for Sequence SEQ_REG_MARK
--------------------------------------------------------

   CREATE SEQUENCE  "VRS"."SEQ_REG_MARK"  MINVALUE 1 MAXVALUE 9999999999999999999999999999 INCREMENT BY 1 START WITH 32822341 NOCACHE  NOORDER  NOCYCLE  NOKEEP  NOSCALE  GLOBAL ;
  GRANT SELECT ON "VRS"."SEQ_REG_MARK" TO "MVIS";
--------------------------------------------------------
--  DDL for Sequence SEQ_REG_MODEL
--------------------------------------------------------

   CREATE SEQUENCE  "VRS"."SEQ_REG_MODEL"  MINVALUE 1 MAXVALUE 9999999999999999999999999999 INCREMENT BY 1 START WITH 45989609 NOCACHE  NOORDER  NOCYCLE  NOKEEP  NOSCALE  GLOBAL ;
  GRANT SELECT ON "VRS"."SEQ_REG_MODEL" TO "MVIS";
--------------------------------------------------------
--  DDL for Sequence SEQ_REG_MODIPICACE
--------------------------------------------------------

   CREATE SEQUENCE  "VRS"."SEQ_REG_MODIPICACE"  MINVALUE 1 MAXVALUE 9999999999999999999999999999 INCREMENT BY 1 START WITH 46000586 NOCACHE  NOORDER  NOCYCLE  NOKEEP  NOSCALE  GLOBAL ;
  GRANT SELECT ON "VRS"."SEQ_REG_MODIPICACE" TO "MVIS";
--------------------------------------------------------
--  DDL for Sequence SEQ_REG_OWNER
--------------------------------------------------------

   CREATE SEQUENCE  "VRS"."SEQ_REG_OWNER"  MINVALUE 1 MAXVALUE 9999999999999999999999999999 INCREMENT BY 1 START WITH 924044 NOCACHE  NOORDER  NOCYCLE  NOKEEP  NOSCALE  GLOBAL ;
  GRANT SELECT ON "VRS"."SEQ_REG_OWNER" TO "MVIS";
--------------------------------------------------------
--  DDL for Sequence SEQ_REG_RFID_TAG
--------------------------------------------------------

   CREATE SEQUENCE  "VRS"."SEQ_REG_RFID_TAG"  MINVALUE 1 MAXVALUE 9999999999999999999999999999 INCREMENT BY 1 START WITH 1 CACHE 20 NOORDER  NOCYCLE  NOKEEP  NOSCALE  GLOBAL ;
--------------------------------------------------------
--  DDL for Sequence SEQ_REG_VEHICLE
--------------------------------------------------------

   CREATE SEQUENCE  "VRS"."SEQ_REG_VEHICLE"  MINVALUE 1 MAXVALUE 9999999999999999999999999999 INCREMENT BY 1 START WITH 2417342 CACHE 20 NOORDER  NOCYCLE  NOKEEP  NOSCALE  GLOBAL ;
  GRANT SELECT ON "VRS"."SEQ_REG_VEHICLE" TO "MVIS";
--------------------------------------------------------
--  DDL for Sequence SEQ_REG_VEHICLE_INSP_ARCHIVE
--------------------------------------------------------

   CREATE SEQUENCE  "VRS"."SEQ_REG_VEHICLE_INSP_ARCHIVE"  MINVALUE 1 MAXVALUE 9999999999999999999999999999 INCREMENT BY 1 START WITH 1316607 CACHE 20 NOORDER  NOCYCLE  NOKEEP  NOSCALE  GLOBAL ;
--------------------------------------------------------
--  DDL for Sequence SEQ_REG_VEHICLE_OWNERSHIP
--------------------------------------------------------

   CREATE SEQUENCE  "VRS"."SEQ_REG_VEHICLE_OWNERSHIP"  MINVALUE 1 MAXVALUE 9999999999999999999999999999 INCREMENT BY 1 START WITH 573 NOCACHE  NOORDER  NOCYCLE  NOKEEP  NOSCALE  GLOBAL ;
  GRANT SELECT ON "VRS"."SEQ_REG_VEHICLE_OWNERSHIP" TO "MVIS";
--------------------------------------------------------
--  DDL for Sequence SEQ_REG_VEHICLE_TYPE
--------------------------------------------------------

   CREATE SEQUENCE  "VRS"."SEQ_REG_VEHICLE_TYPE"  MINVALUE 1 MAXVALUE 9999999999999999999999999999 INCREMENT BY 1 START WITH 362 NOCACHE  NOORDER  NOCYCLE  NOKEEP  NOSCALE  GLOBAL ;
  GRANT SELECT ON "VRS"."SEQ_REG_VEHICLE_TYPE" TO "MVIS";
--------------------------------------------------------
--  DDL for Sequence SERIES_INTERVAL_SEQ
--------------------------------------------------------

   CREATE SEQUENCE  "VRS"."SERIES_INTERVAL_SEQ"  MINVALUE 1 MAXVALUE 9999999999999999999999999999 INCREMENT BY 1 START WITH 42857 CACHE 20 NOORDER  NOCYCLE  NOKEEP  NOSCALE  GLOBAL ;
--------------------------------------------------------
--  DDL for Sequence SERIES_NUMBER_SEQ
--------------------------------------------------------

   CREATE SEQUENCE  "VRS"."SERIES_NUMBER_SEQ"  MINVALUE 1 MAXVALUE 9999999999999999999999999999 INCREMENT BY 1 START WITH 2762969 CACHE 20 NOORDER  NOCYCLE  NOKEEP  NOSCALE  GLOBAL ;
--------------------------------------------------------
--  DDL for Sequence SERIES_SEQ
--------------------------------------------------------

   CREATE SEQUENCE  "VRS"."SERIES_SEQ"  MINVALUE 1 MAXVALUE 9999999999999999999999999999 INCREMENT BY 1 START WITH 1475 CACHE 20 NOORDER  NOCYCLE  NOKEEP  NOSCALE  GLOBAL ;
--------------------------------------------------------
--  DDL for Sequence SYSTEM_ARCHIVE_SEQ
--------------------------------------------------------

   CREATE SEQUENCE  "VRS"."SYSTEM_ARCHIVE_SEQ"  MINVALUE 1 MAXVALUE 9999999999999999999999999999 INCREMENT BY 1 START WITH 321 CACHE 20 NOORDER  NOCYCLE  NOKEEP  NOSCALE  GLOBAL ;
--------------------------------------------------------
--  DDL for Sequence SYSTEM_DEPARTMENT_SEQ
--------------------------------------------------------

   CREATE SEQUENCE  "VRS"."SYSTEM_DEPARTMENT_SEQ"  MINVALUE 1 MAXVALUE 9999999999999999999999999999 INCREMENT BY 1 START WITH 683 CACHE 20 NOORDER  NOCYCLE  NOKEEP  NOSCALE  GLOBAL ;
--------------------------------------------------------
--  DDL for Sequence SYSTEM_DEPTYPE_SEQ
--------------------------------------------------------

   CREATE SEQUENCE  "VRS"."SYSTEM_DEPTYPE_SEQ"  MINVALUE 1 MAXVALUE 9999999999999999999999999999 INCREMENT BY 1 START WITH 1 CACHE 20 NOORDER  NOCYCLE  NOKEEP  NOSCALE  GLOBAL ;
--------------------------------------------------------
--  DDL for Sequence SYSTEM_DIVISION_SEQ
--------------------------------------------------------

   CREATE SEQUENCE  "VRS"."SYSTEM_DIVISION_SEQ"  MINVALUE 1 MAXVALUE 9999999999999999999999999999 INCREMENT BY 1 START WITH 21 CACHE 20 NOORDER  NOCYCLE  NOKEEP  NOSCALE  GLOBAL ;
--------------------------------------------------------
--  DDL for Sequence SYSTEM_ISSUE_SEQ
--------------------------------------------------------

   CREATE SEQUENCE  "VRS"."SYSTEM_ISSUE_SEQ"  MINVALUE 1 MAXVALUE 9999999999999999999999999999 INCREMENT BY 1 START WITH 722 CACHE 20 NOORDER  NOCYCLE  NOKEEP  NOSCALE  GLOBAL ;
--------------------------------------------------------
--  DDL for Sequence SYSTEM_ISSUE_SEQ1
--------------------------------------------------------

   CREATE SEQUENCE  "VRS"."SYSTEM_ISSUE_SEQ1"  MINVALUE 1 MAXVALUE 9999999999999999999999999999 INCREMENT BY 1 START WITH 782 CACHE 20 NOORDER  NOCYCLE  NOKEEP  NOSCALE  GLOBAL ;
--------------------------------------------------------
--  DDL for Sequence SYSTEM_PLATE_FACTORY_SEQ
--------------------------------------------------------

   CREATE SEQUENCE  "VRS"."SYSTEM_PLATE_FACTORY_SEQ"  MINVALUE 1 MAXVALUE 9999999999999999999999999999 INCREMENT BY 1 START WITH 1561516 CACHE 20 NOORDER  NOCYCLE  NOKEEP  NOSCALE  GLOBAL ;
--------------------------------------------------------
--  DDL for Sequence SYSTEM_POSITION_LOG_SEQ
--------------------------------------------------------

   CREATE SEQUENCE  "VRS"."SYSTEM_POSITION_LOG_SEQ"  MINVALUE 1 MAXVALUE 9999999999999999999999999999 INCREMENT BY 1 START WITH 58382 CACHE 20 NOORDER  NOCYCLE  NOKEEP  NOSCALE  GLOBAL ;
--------------------------------------------------------
--  DDL for Sequence SYSTEM_POSITION_SEQ
--------------------------------------------------------

   CREATE SEQUENCE  "VRS"."SYSTEM_POSITION_SEQ"  MINVALUE 1 MAXVALUE 9999999999999999999999999999 INCREMENT BY 1 START WITH 908 CACHE 20 NOORDER  NOCYCLE  NOKEEP  NOSCALE  GLOBAL ;
--------------------------------------------------------
--  DDL for Sequence SYSTEM_SERVICE_SEQ
--------------------------------------------------------

   CREATE SEQUENCE  "VRS"."SYSTEM_SERVICE_SEQ"  MINVALUE 1 MAXVALUE 9999999999999999999999999999 INCREMENT BY 1 START WITH 32 CACHE 20 NOORDER  NOCYCLE  NOKEEP  NOSCALE  GLOBAL ;
--------------------------------------------------------
--  DDL for Sequence SYSTEM_USER_MENU_SEQ
--------------------------------------------------------

   CREATE SEQUENCE  "VRS"."SYSTEM_USER_MENU_SEQ"  MINVALUE 1 MAXVALUE 9999999999999999999999999999 INCREMENT BY 1 START WITH 67227 CACHE 20 NOORDER  NOCYCLE  NOKEEP  NOSCALE  GLOBAL ;
--------------------------------------------------------
--  DDL for Sequence SYSTEM_USER_SEQ
--------------------------------------------------------

   CREATE SEQUENCE  "VRS"."SYSTEM_USER_SEQ"  MINVALUE 1 MAXVALUE 9999999999999999999999999999 INCREMENT BY 1 START WITH 8972 CACHE 20 NOORDER  NOCYCLE  NOKEEP  NOSCALE  GLOBAL ;
--------------------------------------------------------
--  DDL for Sequence TRANSACTION_SEQ
--------------------------------------------------------

   CREATE SEQUENCE  "VRS"."TRANSACTION_SEQ"  MINVALUE 1 MAXVALUE 9999999999999999999999999999 INCREMENT BY 1 START WITH 61 CACHE 20 NOORDER  NOCYCLE  NOKEEP  NOSCALE  GLOBAL ;
--------------------------------------------------------
--  DDL for Sequence VEHICLE_TYPE_SEQ
--------------------------------------------------------

   CREATE SEQUENCE  "VRS"."VEHICLE_TYPE_SEQ"  MINVALUE 1 MAXVALUE 9999999999999999999999999999 INCREMENT BY 1 START WITH 21 CACHE 20 NOORDER  NOCYCLE  NOKEEP  NOSCALE  GLOBAL ;
--------------------------------------------------------
--  DDL for Table ADDRESS_MICRODISTRICT
--------------------------------------------------------

  CREATE TABLE "VRS"."ADDRESS_MICRODISTRICT" 
   (	"ID" NUMBER(10,0), 
	"CODE" VARCHAR2(250 BYTE), 
	"NAME" VARCHAR2(250 BYTE), 
	"DEVISION_UNIT_ID" NUMBER(10,0), 
	"CREATED_BY_ID" NUMBER(10,0), 
	"UPDATED_BY_ID" NUMBER(10,0), 
	"CREATE_DATE" TIMESTAMP (6), 
	"UPDATE_DATE" TIMESTAMP (6)
   ) SEGMENT CREATION IMMEDIATE 
  PCTFREE 10 PCTUSED 40 INITRANS 1 MAXTRANS 255 
 NOCOMPRESS LOGGING
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_DATA" ;
  GRANT SELECT ON "VRS"."ADDRESS_MICRODISTRICT" TO "USER_INSP";
  GRANT SELECT ON "VRS"."ADDRESS_MICRODISTRICT" TO "MVIS";
  GRANT SELECT ON "VRS"."ADDRESS_MICRODISTRICT" TO "USER_ZHUT";
--------------------------------------------------------
--  DDL for Table ADDRESS_PROVINCE
--------------------------------------------------------

  CREATE TABLE "VRS"."ADDRESS_PROVINCE" 
   (	"ID" NUMBER(3,0), 
	"NAME" VARCHAR2(255 CHAR), 
	"ABBR" VARCHAR2(255 CHAR), 
	"OLD_ID" NUMBER(5,0)
   ) SEGMENT CREATION IMMEDIATE 
  PCTFREE 10 PCTUSED 40 INITRANS 1 MAXTRANS 255 
 NOCOMPRESS LOGGING
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_DATA" ;
  GRANT SELECT ON "VRS"."ADDRESS_PROVINCE" TO "MVIS";
  GRANT SELECT ON "VRS"."ADDRESS_PROVINCE" TO "USER_INSP";
--------------------------------------------------------
--  DDL for Table ADDRESS_PROVINCE_OLD
--------------------------------------------------------

  CREATE TABLE "VRS"."ADDRESS_PROVINCE_OLD" 
   (	"ID" NUMBER(19,0), 
	"CREATE_DATE" TIMESTAMP (6), 
	"NAME" VARCHAR2(255 CHAR), 
	"UPDATE_DATE" TIMESTAMP (6), 
	"ABBR" VARCHAR2(255 CHAR), 
	"CREATED_BY_ID" NUMBER(19,0), 
	"UPDATED_BY_ID" NUMBER(19,0), 
	"NEW_ID" NUMBER(2,0)
   ) SEGMENT CREATION IMMEDIATE 
  PCTFREE 10 PCTUSED 40 INITRANS 1 MAXTRANS 255 
 NOCOMPRESS LOGGING
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_DATA" ;
  GRANT SELECT ON "VRS"."ADDRESS_PROVINCE_OLD" TO "MVIS";
  GRANT SELECT ON "VRS"."ADDRESS_PROVINCE_OLD" TO "USER_INSP";
  GRANT SELECT ON "VRS"."ADDRESS_PROVINCE_OLD" TO "USER_ZHUT";
--------------------------------------------------------
--  DDL for Table ADDRESS_SUBDEV
--------------------------------------------------------

  CREATE TABLE "VRS"."ADDRESS_SUBDEV" 
   (	"ID" NUMBER(5,0), 
	"NAME" VARCHAR2(255 CHAR), 
	"PROVINCE_ID" NUMBER(3,0), 
	"CREATED_BY" NUMBER(5,0), 
	"CREATE_DATE" TIMESTAMP (6), 
	"UPDATE_DATE" TIMESTAMP (6), 
	"UPDATED_BY" NUMBER(5,0), 
	"OLD_ID" NUMBER(8,0)
   ) SEGMENT CREATION IMMEDIATE 
  PCTFREE 10 PCTUSED 40 INITRANS 1 MAXTRANS 255 
 NOCOMPRESS LOGGING
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_DATA" ;
  GRANT SELECT ON "VRS"."ADDRESS_SUBDEV" TO "MVIS";
  GRANT SELECT ON "VRS"."ADDRESS_SUBDEV" TO "USER_INSP";
  GRANT INSERT ON "VRS"."ADDRESS_SUBDEV" TO "MVIS";
  GRANT UPDATE ON "VRS"."ADDRESS_SUBDEV" TO "MVIS";
--------------------------------------------------------
--  DDL for Table ADDRESS_SUBDEV_OLD
--------------------------------------------------------

  CREATE TABLE "VRS"."ADDRESS_SUBDEV_OLD" 
   (	"ID" NUMBER(19,0), 
	"CREATE_DATE" TIMESTAMP (6), 
	"NAME" VARCHAR2(255 CHAR), 
	"UPDATE_DATE" TIMESTAMP (6), 
	"CREATED_BY_ID" NUMBER(19,0), 
	"UPDATED_BY_ID" NUMBER(19,0), 
	"PROVINCE_ID" NUMBER(19,0)
   ) SEGMENT CREATION IMMEDIATE 
  PCTFREE 10 PCTUSED 40 INITRANS 1 MAXTRANS 255 
 NOCOMPRESS LOGGING
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_DATA" ;
  GRANT SELECT ON "VRS"."ADDRESS_SUBDEV_OLD" TO "MVIS";
  GRANT SELECT ON "VRS"."ADDRESS_SUBDEV_OLD" TO "USER_INSP";
  GRANT SELECT ON "VRS"."ADDRESS_SUBDEV_OLD" TO "USER_ZHUT";
--------------------------------------------------------
--  DDL for Table ADDRESS_SUBDEV_UNIT
--------------------------------------------------------

  CREATE TABLE "VRS"."ADDRESS_SUBDEV_UNIT" 
   (	"ID" NUMBER(8,0), 
	"NAME" VARCHAR2(255 CHAR), 
	"DEVISION_ID" NUMBER(5,0), 
	"CREATED_BY" NUMBER(5,0), 
	"CREATE_DATE" TIMESTAMP (6), 
	"UPDATE_DATE" TIMESTAMP (6), 
	"UPDATED_BY" NUMBER(5,0)
   ) SEGMENT CREATION IMMEDIATE 
  PCTFREE 10 PCTUSED 40 INITRANS 1 MAXTRANS 255 
 NOCOMPRESS LOGGING
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_DATA" ;
  GRANT SELECT ON "VRS"."ADDRESS_SUBDEV_UNIT" TO "MVIS";
  GRANT SELECT ON "VRS"."ADDRESS_SUBDEV_UNIT" TO "USER_INSP";
  GRANT INSERT ON "VRS"."ADDRESS_SUBDEV_UNIT" TO "MVIS";
  GRANT UPDATE ON "VRS"."ADDRESS_SUBDEV_UNIT" TO "MVIS";
--------------------------------------------------------
--  DDL for Table ADDRESS_SUBDEV_UNIT_OLD
--------------------------------------------------------

  CREATE TABLE "VRS"."ADDRESS_SUBDEV_UNIT_OLD" 
   (	"ID" NUMBER(19,0), 
	"CREATE_DATE" TIMESTAMP (6), 
	"NAME" VARCHAR2(255 CHAR), 
	"UPDATE_DATE" TIMESTAMP (6), 
	"CREATED_BY_ID" NUMBER(19,0), 
	"UPDATED_BY_ID" NUMBER(19,0), 
	"DEVISION_ID" NUMBER(19,0)
   ) SEGMENT CREATION IMMEDIATE 
  PCTFREE 10 PCTUSED 40 INITRANS 1 MAXTRANS 255 
 NOCOMPRESS LOGGING
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_DATA" ;
  GRANT SELECT ON "VRS"."ADDRESS_SUBDEV_UNIT_OLD" TO "USER_INSP";
  GRANT SELECT ON "VRS"."ADDRESS_SUBDEV_UNIT_OLD" TO "MVIS";
  GRANT SELECT ON "VRS"."ADDRESS_SUBDEV_UNIT_OLD" TO "USER_ZHUT";
--------------------------------------------------------
--  DDL for Table ARCHIVE_NUMBER
--------------------------------------------------------

  CREATE TABLE "VRS"."ARCHIVE_NUMBER" 
   (	"ID" NUMBER(19,0), 
	"CREATEDDATE" TIMESTAMP (6), 
	"UPDATEDDATE" TIMESTAMP (6), 
	"DELETE_COUNT" NUMBER(10,0), 
	"MONTH" NUMBER(10,0), 
	"NEW_COUNT" NUMBER(10,0), 
	"YEAR" NUMBER(10,0), 
	"CREATEDBY" NUMBER(19,0), 
	"MODIFIEDBY" NUMBER(19,0), 
	"ARCHIVE_DEPARTMENT_ID" NUMBER(19,0), 
	"ABBR" VARCHAR2(100 BYTE), 
	"OTHER_COUNT" NUMBER(19,0), 
	"PLATE_SAVE_COUNT" NUMBER(19,0) DEFAULT 0
   ) SEGMENT CREATION IMMEDIATE 
  PCTFREE 10 PCTUSED 40 INITRANS 1 MAXTRANS 255 
 NOCOMPRESS LOGGING
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_DATA" ;
  GRANT SELECT ON "VRS"."ARCHIVE_NUMBER" TO "USER_EMONGOL";
  GRANT UPDATE ON "VRS"."ARCHIVE_NUMBER" TO "USER_EMONGOL";
--------------------------------------------------------
--  DDL for Table AUDITS
--------------------------------------------------------

  CREATE TABLE "VRS"."AUDITS" 
   (	"ID" NUMBER(10,0), 
	"USER_TYPE" VARCHAR2(255 BYTE), 
	"USER_ID" VARCHAR2(200 BYTE), 
	"EVENT" VARCHAR2(255 BYTE), 
	"AUDITABLE_ID" VARCHAR2(200 BYTE), 
	"AUDITABLE_TYPE" VARCHAR2(255 BYTE), 
	"OLD_VALUES" CLOB, 
	"NEW_VALUES" CLOB, 
	"URL" CLOB, 
	"IP_ADDRESS" CLOB, 
	"USER_AGENT" VARCHAR2(255 BYTE), 
	"TAGS" VARCHAR2(255 BYTE), 
	"CREATED_AT" TIMESTAMP (6), 
	"UPDATED_AT" TIMESTAMP (6)
   ) SEGMENT CREATION IMMEDIATE 
  PCTFREE 10 PCTUSED 40 INITRANS 1 MAXTRANS 255 
 NOCOMPRESS LOGGING
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_DATA" 
 LOB ("OLD_VALUES") STORE AS BASICFILE (
  TABLESPACE "VRS_DATA" ENABLE STORAGE IN ROW CHUNK 8192 RETENTION 
  NOCACHE LOGGING 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)) 
 LOB ("NEW_VALUES") STORE AS BASICFILE (
  TABLESPACE "VRS_DATA" ENABLE STORAGE IN ROW CHUNK 8192 RETENTION 
  NOCACHE LOGGING 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)) 
 LOB ("URL") STORE AS BASICFILE (
  TABLESPACE "VRS_DATA" ENABLE STORAGE IN ROW CHUNK 8192 RETENTION 
  NOCACHE LOGGING 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)) 
 LOB ("IP_ADDRESS") STORE AS BASICFILE (
  TABLESPACE "VRS_DATA" ENABLE STORAGE IN ROW CHUNK 8192 RETENTION 
  NOCACHE LOGGING 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)) ;
--------------------------------------------------------
--  DDL for Table EPAY_TRANSACTION
--------------------------------------------------------

  CREATE TABLE "VRS"."EPAY_TRANSACTION" 
   (	"ID" NUMBER(38,0), 
	"TRANSACTION_ID" NUMBER(38,0), 
	"VEHICLE_ID" NUMBER(38,0), 
	"ARKHIVE_NO" NVARCHAR2(50), 
	"AMOUNT" NVARCHAR2(50), 
	"PAY_TYPE" NUMBER(10,0) DEFAULT 0, 
	"CREATED_BY" NUMBER(38,0), 
	"CREATED_AT" DATE, 
	"PAY_TYPE_NAME" NVARCHAR2(50), 
	"SERVICE_TYPE" VARCHAR2(20 BYTE), 
	"SERVICE_ID" NUMBER(10,0)
   ) SEGMENT CREATION IMMEDIATE 
  PCTFREE 10 PCTUSED 40 INITRANS 1 MAXTRANS 255 
 NOCOMPRESS LOGGING
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "USERS" ;
--------------------------------------------------------
--  DDL for Table ESIGN
--------------------------------------------------------

  CREATE TABLE "VRS"."ESIGN" 
   (	"ID" NUMBER(20,0), 
	"BORROWER_REGNUM" VARCHAR2(20 BYTE), 
	"OWNER_REGNUM" VARCHAR2(20 BYTE), 
	"NEW_OWNER_REGNUM" VARCHAR2(20 BYTE), 
	"VEHICLE_ID" NUMBER(10,0) DEFAULT 0, 
	"IS_APPROVED" NUMBER(10,0) DEFAULT 0, 
	"IS_PAID" NUMBER(10,0) DEFAULT 0, 
	"IS_BORROWING" NUMBER(10,0) DEFAULT 0, 
	"NOTE" VARCHAR2(1000 BYTE), 
	"REQUEST_CODE" VARCHAR2(255 BYTE), 
	"SERVICE_CODE" VARCHAR2(20 BYTE), 
	"SIGNATURE_DATA" CLOB, 
	"CREATED_DATE" DATE, 
	"IS_DELETED" NUMBER(11,0) DEFAULT 0
   ) SEGMENT CREATION IMMEDIATE 
  PCTFREE 10 PCTUSED 40 INITRANS 1 MAXTRANS 255 
 NOCOMPRESS LOGGING
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "USERS" 
 LOB ("SIGNATURE_DATA") STORE AS SECUREFILE (
  TABLESPACE "USERS" ENABLE STORAGE IN ROW CHUNK 8192
  NOCACHE LOGGING  NOCOMPRESS  KEEP_DUPLICATES 
  STORAGE(INITIAL 106496 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)) ;
  GRANT INSERT ON "VRS"."ESIGN" TO "USER_INSP";
  GRANT SELECT ON "VRS"."ESIGN" TO "USER_INSP";
  GRANT UPDATE ON "VRS"."ESIGN" TO "USER_INSP";
--------------------------------------------------------
--  DDL for Table FIX_OWNER_2507145
--------------------------------------------------------

  CREATE TABLE "VRS"."FIX_OWNER_2507145" 
   (	"ID" NUMBER(4,0), 
	"MARK" VARCHAR2(50 BYTE), 
	"PLATE_NO" VARCHAR2(26 BYTE), 
	"CABIN_NO" VARCHAR2(50 BYTE), 
	"VEHICLE_ID" NUMBER(38,0), 
	"VRS_PLATE_NO" NVARCHAR2(50), 
	"VRS_CABIN_NO" NVARCHAR2(50), 
	"MARK_NAME" VARCHAR2(500 BYTE), 
	"MODEL_NAME" VARCHAR2(100 BYTE), 
	"OWNER_TYPE_NAME" VARCHAR2(255 CHAR), 
	"REGISTER_NO" VARCHAR2(24 BYTE), 
	"FIRST_NAME" VARCHAR2(255 BYTE)
   ) SEGMENT CREATION IMMEDIATE 
  PCTFREE 10 PCTUSED 40 INITRANS 1 MAXTRANS 255 
 NOCOMPRESS LOGGING
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "USERS" ;
--------------------------------------------------------
--  DDL for Table LOG_UPDATED
--------------------------------------------------------

  CREATE TABLE "VRS"."LOG_UPDATED" 
   (	"ID" NUMBER, 
	"REF_ID" NUMBER, 
	"ACTION" VARCHAR2(2 BYTE), 
	"TABLE_NAME" VARCHAR2(20 BYTE), 
	"UPDATED_DATE" DATE, 
	"SEND_STATUS" NUMBER(5,0), 
	"SEND_DATE" DATE
   ) SEGMENT CREATION IMMEDIATE 
  PCTFREE 10 PCTUSED 40 INITRANS 1 MAXTRANS 255 
 NOCOMPRESS LOGGING
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "USERS" ;
  GRANT INSERT ON "VRS"."LOG_UPDATED" TO "MVIS";
  GRANT SELECT ON "VRS"."LOG_UPDATED" TO "MVIS";
  GRANT UPDATE ON "VRS"."LOG_UPDATED" TO "MVIS";
--------------------------------------------------------
--  DDL for Table OLD_VEHICLE_DATA
--------------------------------------------------------

  CREATE TABLE "VRS"."OLD_VEHICLE_DATA" 
   (	"VEHICLE_ID" NUMBER(38,0), 
	"COLOR_NAME" NVARCHAR2(50), 
	"COUNTRY_ID" NUMBER(18,0), 
	"MARK_ID" NUMBER(18,0), 
	"MARK_NAME" NVARCHAR2(100), 
	"MODEL_NAME" NVARCHAR2(100), 
	"CREATED_DATE" DATE
   ) SEGMENT CREATION IMMEDIATE 
  PCTFREE 10 PCTUSED 40 INITRANS 1 MAXTRANS 255 
 NOCOMPRESS LOGGING
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "USERS" ;
--------------------------------------------------------
--  DDL for Table OWNER
--------------------------------------------------------

  CREATE TABLE "VRS"."OWNER" 
   (	"ID" NUMBER(18,0), 
	"TYPE_ID" NUMBER(2,0), 
	"GENDER" NUMBER(2,0), 
	"REGISTER_NO" VARCHAR2(24 BYTE), 
	"FAMILY_NAME" VARCHAR2(255 BYTE), 
	"LAST_NAME" VARCHAR2(255 BYTE), 
	"FIRST_NAME" VARCHAR2(255 BYTE), 
	"COUNTRY_ID" NUMBER(6,0), 
	"DEVISION_UNIT_ID" NUMBER(10,0), 
	"ADDRESS_DETAIL" VARCHAR2(500 BYTE), 
	"HOMEPHONE" VARCHAR2(255 BYTE), 
	"WORKPHONE" VARCHAR2(255 BYTE), 
	"CELLPHONE" VARCHAR2(255 BYTE), 
	"CIVIL_ID" NUMBER(18,0), 
	"ORDER_QTY" NUMBER(3,0), 
	"STATUS" NUMBER(2,0), 
	"CREATED_BY_ID" NUMBER(5,0), 
	"CREATE_DATE" DATE, 
	"UPDATED_BY_ID" NUMBER(5,0), 
	"UPDATE_DATE" DATE, 
	"OLD_PROVINCE_ID" NUMBER(5,0), 
	"OLD_DISTRICT_ID" NUMBER(5,0), 
	"OLD_DEVISION_UNIT_ID" NUMBER(5,0), 
	"XYP_RESULT_CODE" NUMBER(2,0)
   ) SEGMENT CREATION IMMEDIATE 
  PCTFREE 10 PCTUSED 40 INITRANS 1 MAXTRANS 255 
 NOCOMPRESS LOGGING
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "USERS" ;
  GRANT SELECT ON "VRS"."OWNER" TO "MVIS";
  GRANT SELECT ON "VRS"."OWNER" TO "USER_INSP";
  GRANT SELECT ON "VRS"."OWNER" TO "USER_NDC";
  GRANT UPDATE ON "VRS"."OWNER" TO "MVIS";
  GRANT INSERT ON "VRS"."OWNER" TO "USER_EMONGOL";
  GRANT SELECT ON "VRS"."OWNER" TO "USER_EMONGOL";
  GRANT UPDATE ON "VRS"."OWNER" TO "USER_EMONGOL";
--------------------------------------------------------
--  DDL for Table OWNER_OLD
--------------------------------------------------------

  CREATE TABLE "VRS"."OWNER_OLD" 
   (	"ID" NUMBER(18,0), 
	"CREATE_DATE" DATE, 
	"CREATED_BY_ID" NUMBER(18,0), 
	"REGISTER_NO" VARCHAR2(24 BYTE), 
	"TYPE_ID" NUMBER(18,0), 
	"FAMILY_NAME" VARCHAR2(255 BYTE), 
	"LAST_NAME" VARCHAR2(255 BYTE), 
	"FIRST_NAME" VARCHAR2(255 BYTE), 
	"COUNTRY_ID" NUMBER(18,0), 
	"PROVINCE_ID" NUMBER(18,0), 
	"DISTRICT_ID" NUMBER(18,0), 
	"DEVISION_UNIT_ID" NUMBER(18,0), 
	"MICRO_DISTRICT_ID" NUMBER(18,0), 
	"STREET" VARCHAR2(255 BYTE), 
	"APARTMENT_NO" VARCHAR2(255 BYTE), 
	"DOOR_NO" VARCHAR2(255 BYTE), 
	"ADDRESS_DETAIL" VARCHAR2(255 BYTE), 
	"HOMEPHONE" VARCHAR2(255 BYTE), 
	"WORKPHONE" VARCHAR2(255 BYTE), 
	"CELLPHONE" VARCHAR2(255 BYTE), 
	"ZIP" VARCHAR2(20 BYTE), 
	"GENDER" NUMBER(18,0), 
	"UPDATE_DATE" DATE, 
	"UPDATED_BY_ID" NUMBER(18,0), 
	"CIVIL_ID" NUMBER(18,0), 
	"MORE_INFO" VARCHAR2(255 BYTE), 
	"ORDER_QTY" NUMBER(18,0), 
	"STATUS" NUMBER(2,0)
   ) SEGMENT CREATION IMMEDIATE 
  PCTFREE 10 PCTUSED 40 INITRANS 1 MAXTRANS 255 
 NOCOMPRESS LOGGING
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_DATA" ;
  GRANT SELECT ON "VRS"."OWNER_OLD" TO "MVIS";
  GRANT SELECT ON "VRS"."OWNER_OLD" TO "USER_INSP";
  GRANT SELECT ON "VRS"."OWNER_OLD" TO "USER_NDC";
--------------------------------------------------------
--  DDL for Table OWNER_STATUS
--------------------------------------------------------

  CREATE TABLE "VRS"."OWNER_STATUS" 
   (	"ID" NUMBER(5,0), 
	"NAME" VARCHAR2(40 BYTE)
   ) SEGMENT CREATION IMMEDIATE 
  PCTFREE 10 PCTUSED 40 INITRANS 1 MAXTRANS 255 
 NOCOMPRESS LOGGING
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "USERS" ;
--------------------------------------------------------
--  DDL for Table OWNER_TYPE
--------------------------------------------------------

  CREATE TABLE "VRS"."OWNER_TYPE" 
   (	"ID" NUMBER(19,0), 
	"CREATEDDATE" TIMESTAMP (6), 
	"NAME" VARCHAR2(255 CHAR), 
	"UPDATEDDATE" TIMESTAMP (6), 
	"TYPE" VARCHAR2(255 CHAR), 
	"CREATEDBY" NUMBER(19,0), 
	"UPDATEDBY" NUMBER(19,0)
   ) SEGMENT CREATION IMMEDIATE 
  PCTFREE 10 PCTUSED 40 INITRANS 1 MAXTRANS 255 
 NOCOMPRESS LOGGING
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_DATA" ;
  GRANT SELECT ON "VRS"."OWNER_TYPE" TO "MVIS";
  GRANT SELECT ON "VRS"."OWNER_TYPE" TO "USER_NDC";
--------------------------------------------------------
--  DDL for Table REF_COLOR
--------------------------------------------------------

  CREATE TABLE "VRS"."REF_COLOR" 
   (	"ID" NUMBER, 
	"NAME" VARCHAR2(50 BYTE), 
	"TYPE_ID" NUMBER, 
	"STATUS" NUMBER(1,0)
   ) SEGMENT CREATION IMMEDIATE 
  PCTFREE 10 PCTUSED 40 INITRANS 1 MAXTRANS 255 
 NOCOMPRESS LOGGING
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_DATA" ;
  GRANT FLASHBACK ON "VRS"."REF_COLOR" TO "MVIS";
  GRANT DEBUG ON "VRS"."REF_COLOR" TO "MVIS";
  GRANT QUERY REWRITE ON "VRS"."REF_COLOR" TO "MVIS";
  GRANT ON COMMIT REFRESH ON "VRS"."REF_COLOR" TO "MVIS";
  GRANT REFERENCES ON "VRS"."REF_COLOR" TO "MVIS";
  GRANT INDEX ON "VRS"."REF_COLOR" TO "MVIS";
  GRANT ALTER ON "VRS"."REF_COLOR" TO "MVIS";
  GRANT SELECT ON "VRS"."REF_COLOR" TO "USER_INSP";
  GRANT DELETE ON "VRS"."REF_COLOR" TO "MVIS";
  GRANT SELECT ON "VRS"."REF_COLOR" TO "MVIS";
  GRANT UPDATE ON "VRS"."REF_COLOR" TO "MVIS";
  GRANT INSERT ON "VRS"."REF_COLOR" TO "MVIS";
--------------------------------------------------------
--  DDL for Table REF_COLOR_TYPE
--------------------------------------------------------

  CREATE TABLE "VRS"."REF_COLOR_TYPE" 
   (	"ID" NUMBER, 
	"NAME" VARCHAR2(20 BYTE)
   ) SEGMENT CREATION IMMEDIATE 
  PCTFREE 10 PCTUSED 40 INITRANS 1 MAXTRANS 255 
 NOCOMPRESS LOGGING
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_DATA" ;
  GRANT FLASHBACK ON "VRS"."REF_COLOR_TYPE" TO "MVIS";
  GRANT DEBUG ON "VRS"."REF_COLOR_TYPE" TO "MVIS";
  GRANT QUERY REWRITE ON "VRS"."REF_COLOR_TYPE" TO "MVIS";
  GRANT ON COMMIT REFRESH ON "VRS"."REF_COLOR_TYPE" TO "MVIS";
  GRANT REFERENCES ON "VRS"."REF_COLOR_TYPE" TO "MVIS";
  GRANT INDEX ON "VRS"."REF_COLOR_TYPE" TO "MVIS";
  GRANT ALTER ON "VRS"."REF_COLOR_TYPE" TO "MVIS";
  GRANT DELETE ON "VRS"."REF_COLOR_TYPE" TO "MVIS";
  GRANT SELECT ON "VRS"."REF_COLOR_TYPE" TO "MVIS";
  GRANT UPDATE ON "VRS"."REF_COLOR_TYPE" TO "MVIS";
  GRANT INSERT ON "VRS"."REF_COLOR_TYPE" TO "MVIS";
  GRANT FLASHBACK ON "VRS"."REF_COLOR_TYPE" TO "USER_INSP";
  GRANT DEBUG ON "VRS"."REF_COLOR_TYPE" TO "USER_INSP";
  GRANT QUERY REWRITE ON "VRS"."REF_COLOR_TYPE" TO "USER_INSP";
  GRANT ON COMMIT REFRESH ON "VRS"."REF_COLOR_TYPE" TO "USER_INSP";
  GRANT REFERENCES ON "VRS"."REF_COLOR_TYPE" TO "USER_INSP";
  GRANT UPDATE ON "VRS"."REF_COLOR_TYPE" TO "USER_INSP";
  GRANT SELECT ON "VRS"."REF_COLOR_TYPE" TO "USER_INSP";
  GRANT INSERT ON "VRS"."REF_COLOR_TYPE" TO "USER_INSP";
  GRANT INDEX ON "VRS"."REF_COLOR_TYPE" TO "USER_INSP";
  GRANT DELETE ON "VRS"."REF_COLOR_TYPE" TO "USER_INSP";
  GRANT ALTER ON "VRS"."REF_COLOR_TYPE" TO "USER_INSP";
--------------------------------------------------------
--  DDL for Table REF_COUNTRY
--------------------------------------------------------

  CREATE TABLE "VRS"."REF_COUNTRY" 
   (	"ID" NUMBER(19,0), 
	"CREATED_DATE" DATE, 
	"NAME" VARCHAR2(255 CHAR), 
	"UPDATED_DATE" DATE, 
	"CODE" VARCHAR2(255 CHAR), 
	"CREATED_BY" NUMBER(19,0), 
	"UPDATED_BY" NUMBER(19,0), 
	"STATUS" NUMBER(1,0)
   ) SEGMENT CREATION IMMEDIATE 
  PCTFREE 10 PCTUSED 40 INITRANS 1 MAXTRANS 255 
 NOCOMPRESS LOGGING
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_DATA" ;
  GRANT SELECT ON "VRS"."REF_COUNTRY" TO "USER_INSP";
  GRANT DELETE ON "VRS"."REF_COUNTRY" TO "MVIS";
  GRANT SELECT ON "VRS"."REF_COUNTRY" TO "MVIS";
  GRANT UPDATE ON "VRS"."REF_COUNTRY" TO "MVIS";
  GRANT INSERT ON "VRS"."REF_COUNTRY" TO "MVIS";
--------------------------------------------------------
--  DDL for Table REF_ENGINE_MODEL
--------------------------------------------------------

  CREATE TABLE "VRS"."REF_ENGINE_MODEL" 
   (	"ID" NUMBER(38,0), 
	"NAME" VARCHAR2(500 BYTE), 
	"FUEL_TYPE_ID" NUMBER(10,0), 
	"ECO_CLASS_ID" NUMBER(10,0), 
	"STATUS" NUMBER(1,0), 
	"ENGINE_CAPACITY" NUMBER(20,0), 
	"MARK_ID" NUMBER(38,0), 
	"IS_OTHER_MARK" NUMBER(1,0) DEFAULT 0, 
	"ENGINE_POWER" NUMBER(20,0), 
	"UPDATED_BY" NUMBER, 
	"UPDATED_DATE" DATE, 
	"CREATED_BY" NUMBER, 
	"CREATED_DATE" DATE, 
	"OCTANE_NUM_ID" NUMBER(5,0), 
	"IS_TURBO" NUMBER(1,0)
   ) SEGMENT CREATION IMMEDIATE 
  PCTFREE 10 PCTUSED 40 INITRANS 1 MAXTRANS 255 
 NOCOMPRESS LOGGING
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_DATA" ;
  GRANT FLASHBACK ON "VRS"."REF_ENGINE_MODEL" TO "MVIS";
  GRANT DEBUG ON "VRS"."REF_ENGINE_MODEL" TO "MVIS";
  GRANT QUERY REWRITE ON "VRS"."REF_ENGINE_MODEL" TO "MVIS";
  GRANT ON COMMIT REFRESH ON "VRS"."REF_ENGINE_MODEL" TO "MVIS";
  GRANT REFERENCES ON "VRS"."REF_ENGINE_MODEL" TO "MVIS";
  GRANT INDEX ON "VRS"."REF_ENGINE_MODEL" TO "MVIS";
  GRANT DELETE ON "VRS"."REF_ENGINE_MODEL" TO "MVIS";
  GRANT ALTER ON "VRS"."REF_ENGINE_MODEL" TO "MVIS";
  GRANT SELECT ON "VRS"."REF_ENGINE_MODEL" TO "USER_INSP";
  GRANT SELECT ON "VRS"."REF_ENGINE_MODEL" TO "MVIS";
  GRANT UPDATE ON "VRS"."REF_ENGINE_MODEL" TO "MVIS";
  GRANT INSERT ON "VRS"."REF_ENGINE_MODEL" TO "MVIS";
--------------------------------------------------------
--  DDL for Table REF_GENERAL
--------------------------------------------------------

  CREATE TABLE "VRS"."REF_GENERAL" 
   (	"ID" NUMBER(38,0), 
	"REF_TYPE" NUMBER(38,0), 
	"NAME" VARCHAR2(500 BYTE), 
	"CODE" VARCHAR2(50 BYTE), 
	"PARENT_ID" NUMBER(38,0), 
	"STATUS" NUMBER(1,0), 
	"CREATED_BY" NUMBER(38,0), 
	"CREATED_DATE" DATE, 
	"UPDATED_BY" NUMBER(38,0), 
	"UPDATED_DATE" DATE, 
	"OLD_ID" VARCHAR2(20 BYTE)
   ) SEGMENT CREATION IMMEDIATE 
  PCTFREE 10 PCTUSED 40 INITRANS 1 MAXTRANS 255 
 NOCOMPRESS LOGGING
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_DATA" ;
  GRANT FLASHBACK ON "VRS"."REF_GENERAL" TO "MVIS";
  GRANT DEBUG ON "VRS"."REF_GENERAL" TO "MVIS";
  GRANT QUERY REWRITE ON "VRS"."REF_GENERAL" TO "MVIS";
  GRANT ON COMMIT REFRESH ON "VRS"."REF_GENERAL" TO "MVIS";
  GRANT REFERENCES ON "VRS"."REF_GENERAL" TO "MVIS";
  GRANT INDEX ON "VRS"."REF_GENERAL" TO "MVIS";
  GRANT ALTER ON "VRS"."REF_GENERAL" TO "MVIS";
  GRANT SELECT ON "VRS"."REF_GENERAL" TO "USER_INSP";
  GRANT DELETE ON "VRS"."REF_GENERAL" TO "MVIS";
  GRANT SELECT ON "VRS"."REF_GENERAL" TO "MVIS";
  GRANT UPDATE ON "VRS"."REF_GENERAL" TO "MVIS";
  GRANT INSERT ON "VRS"."REF_GENERAL" TO "MVIS";
--------------------------------------------------------
--  DDL for Table REF_GENERAL_TYPE
--------------------------------------------------------

  CREATE TABLE "VRS"."REF_GENERAL_TYPE" 
   (	"ID" NUMBER(38,0), 
	"NAME" VARCHAR2(500 BYTE), 
	"IS_EDIT" NUMBER(1,0)
   ) SEGMENT CREATION IMMEDIATE 
  PCTFREE 10 PCTUSED 40 INITRANS 1 MAXTRANS 255 
 NOCOMPRESS LOGGING
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_DATA" ;
  GRANT FLASHBACK ON "VRS"."REF_GENERAL_TYPE" TO "MVIS";
  GRANT DEBUG ON "VRS"."REF_GENERAL_TYPE" TO "MVIS";
  GRANT QUERY REWRITE ON "VRS"."REF_GENERAL_TYPE" TO "MVIS";
  GRANT ON COMMIT REFRESH ON "VRS"."REF_GENERAL_TYPE" TO "MVIS";
  GRANT REFERENCES ON "VRS"."REF_GENERAL_TYPE" TO "MVIS";
  GRANT INDEX ON "VRS"."REF_GENERAL_TYPE" TO "MVIS";
  GRANT ALTER ON "VRS"."REF_GENERAL_TYPE" TO "MVIS";
  GRANT DELETE ON "VRS"."REF_GENERAL_TYPE" TO "MVIS";
  GRANT SELECT ON "VRS"."REF_GENERAL_TYPE" TO "MVIS";
  GRANT UPDATE ON "VRS"."REF_GENERAL_TYPE" TO "MVIS";
  GRANT INSERT ON "VRS"."REF_GENERAL_TYPE" TO "MVIS";
  GRANT FLASHBACK ON "VRS"."REF_GENERAL_TYPE" TO "USER_INSP";
  GRANT DEBUG ON "VRS"."REF_GENERAL_TYPE" TO "USER_INSP";
  GRANT QUERY REWRITE ON "VRS"."REF_GENERAL_TYPE" TO "USER_INSP";
  GRANT ON COMMIT REFRESH ON "VRS"."REF_GENERAL_TYPE" TO "USER_INSP";
  GRANT REFERENCES ON "VRS"."REF_GENERAL_TYPE" TO "USER_INSP";
  GRANT UPDATE ON "VRS"."REF_GENERAL_TYPE" TO "USER_INSP";
  GRANT SELECT ON "VRS"."REF_GENERAL_TYPE" TO "USER_INSP";
  GRANT INSERT ON "VRS"."REF_GENERAL_TYPE" TO "USER_INSP";
  GRANT INDEX ON "VRS"."REF_GENERAL_TYPE" TO "USER_INSP";
  GRANT DELETE ON "VRS"."REF_GENERAL_TYPE" TO "USER_INSP";
  GRANT ALTER ON "VRS"."REF_GENERAL_TYPE" TO "USER_INSP";
--------------------------------------------------------
--  DDL for Table REF_PURPOSE
--------------------------------------------------------

  CREATE TABLE "VRS"."REF_PURPOSE" 
   (	"ID" NUMBER(38,0), 
	"NAME" VARCHAR2(500 BYTE), 
	"IS_VIN" NUMBER(1,0), 
	"PURPOSE_BASE_ID" NUMBER(38,0), 
	"OLD_ID" NUMBER, 
	"STATUS" NUMBER(1,0), 
	"V_TYPE" NUMBER(1,0)
   ) SEGMENT CREATION IMMEDIATE 
  PCTFREE 10 PCTUSED 40 INITRANS 1 MAXTRANS 255 
 NOCOMPRESS LOGGING
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_DATA" ;
  GRANT FLASHBACK ON "VRS"."REF_PURPOSE" TO "MVIS";
  GRANT DEBUG ON "VRS"."REF_PURPOSE" TO "MVIS";
  GRANT QUERY REWRITE ON "VRS"."REF_PURPOSE" TO "MVIS";
  GRANT ON COMMIT REFRESH ON "VRS"."REF_PURPOSE" TO "MVIS";
  GRANT REFERENCES ON "VRS"."REF_PURPOSE" TO "MVIS";
  GRANT INDEX ON "VRS"."REF_PURPOSE" TO "MVIS";
  GRANT ALTER ON "VRS"."REF_PURPOSE" TO "MVIS";
  GRANT SELECT ON "VRS"."REF_PURPOSE" TO "USER_INSP";
  GRANT DELETE ON "VRS"."REF_PURPOSE" TO "MVIS";
  GRANT SELECT ON "VRS"."REF_PURPOSE" TO "MVIS";
  GRANT UPDATE ON "VRS"."REF_PURPOSE" TO "MVIS";
  GRANT INSERT ON "VRS"."REF_PURPOSE" TO "MVIS";
  GRANT SELECT ON "VRS"."REF_PURPOSE" TO "ORDS_PUBLIC_USER";
--------------------------------------------------------
--  DDL for Table REF_REFERENCE_ORG
--------------------------------------------------------

  CREATE TABLE "VRS"."REF_REFERENCE_ORG" 
   (	"ID" NUMBER(32,0), 
	"NAME" VARCHAR2(250 CHAR), 
	"CREATEDBY" NUMBER, 
	"CREATEDDATE" TIMESTAMP (6), 
	"UPDATEDBY" NUMBER, 
	"UPDATEDDATE" TIMESTAMP (6)
   ) SEGMENT CREATION IMMEDIATE 
  PCTFREE 10 PCTUSED 40 INITRANS 1 MAXTRANS 255 
 NOCOMPRESS LOGGING
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_DATA" ;
--------------------------------------------------------
--  DDL for Table REG_CERTIFICATE
--------------------------------------------------------

  CREATE TABLE "VRS"."REG_CERTIFICATE" 
   (	"ID" NUMBER(20,0), 
	"USER_ID" NUMBER(20,0), 
	"CERTIFICATE_NO" VARCHAR2(50 BYTE), 
	"CREATED_DATE" TIMESTAMP (6), 
	"VEHICLE_ID" NUMBER(20,0), 
	"VEHICLE_PLATE" VARCHAR2(20 BYTE), 
	"SERVICE_ID" NUMBER, 
	"FEE" FLOAT(126)
   ) SEGMENT CREATION IMMEDIATE 
  PCTFREE 10 PCTUSED 40 INITRANS 1 MAXTRANS 255 
 NOCOMPRESS LOGGING
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_DATA" ;
  GRANT INSERT ON "VRS"."REG_CERTIFICATE" TO "USER_EMONGOL";
  GRANT SELECT ON "VRS"."REG_CERTIFICATE" TO "USER_EMONGOL";
  GRANT UPDATE ON "VRS"."REG_CERTIFICATE" TO "USER_EMONGOL";
--------------------------------------------------------
--  DDL for Table REG_EXHAUST_NUMBER
--------------------------------------------------------

  CREATE TABLE "VRS"."REG_EXHAUST_NUMBER" 
   (	"ID" NUMBER(5,0), 
	"VEHICLE_ID" NUMBER, 
	"EXHAUST_NUMBER" VARCHAR2(10 BYTE), 
	"CREATED_BY" NUMBER(5,0), 
	"CREATED_DATE" DATE
   ) SEGMENT CREATION DEFERRED 
  PCTFREE 10 PCTUSED 40 INITRANS 1 MAXTRANS 255 
 NOCOMPRESS LOGGING
  TABLESPACE "USERS" ;
--------------------------------------------------------
--  DDL for Table REG_LIMITED
--------------------------------------------------------

  CREATE TABLE "VRS"."REG_LIMITED" 
   (	"ID" NUMBER(19,0), 
	"CREATEDDATE" TIMESTAMP (6), 
	"NAME" VARCHAR2(255 CHAR), 
	"MODIFIEDDATE" TIMESTAMP (6), 
	"DEC_DATE" TIMESTAMP (6), 
	"DEC_NO" VARCHAR2(255 CHAR), 
	"PHONE_NO" VARCHAR2(255 CHAR), 
	"CREATEDBY" NUMBER(19,0), 
	"MODIFIEDBY" NUMBER(19,0), 
	"RESTORE_USER_ID" NUMBER(19,0), 
	"TYPE_ID" NUMBER(19,0), 
	"VEHICLE_ID" NUMBER(19,0), 
	"IS_RESTORED" NUMBER(1,0), 
	"END_DATE" TIMESTAMP (6), 
	"RESTORE_DEC_NO" VARCHAR2(255 BYTE), 
	"RESTORE_TYPE_ID" VARCHAR2(19 BYTE)
   ) SEGMENT CREATION IMMEDIATE 
  PCTFREE 10 PCTUSED 40 INITRANS 1 MAXTRANS 255 
 NOCOMPRESS LOGGING
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_DATA" ;
  GRANT SELECT ON "VRS"."REG_LIMITED" TO "MVIS";
  GRANT SELECT ON "VRS"."REG_LIMITED" TO "USER_EMONGOL";
--------------------------------------------------------
--  DDL for Table REG_LIMIT_TYPE
--------------------------------------------------------

  CREATE TABLE "VRS"."REG_LIMIT_TYPE" 
   (	"ID" NUMBER(19,0), 
	"CREATE_DATE" TIMESTAMP (6), 
	"NAME" VARCHAR2(255 CHAR), 
	"UPDATE_DATE" TIMESTAMP (6), 
	"CREATED_BY_ID" NUMBER(19,0), 
	"UPDATED_BY_ID" NUMBER(19,0)
   ) SEGMENT CREATION IMMEDIATE 
  PCTFREE 10 PCTUSED 40 INITRANS 1 MAXTRANS 255 
 NOCOMPRESS LOGGING
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_DATA" ;
--------------------------------------------------------
--  DDL for Table REG_MARK
--------------------------------------------------------

  CREATE TABLE "VRS"."REG_MARK" 
   (	"ID" NUMBER(38,0), 
	"NAME" VARCHAR2(500 BYTE), 
	"COUNTRY_ID" NUMBER(38,0), 
	"STATUS" NUMBER(1,0), 
	"CREATED_BY" NUMBER(38,0), 
	"CREATED_DATE" DATE, 
	"UPDATED_BY" NUMBER(38,0), 
	"UPDATED_DATE" DATE, 
	"OLD_ID" NUMBER(38,0)
   ) SEGMENT CREATION IMMEDIATE 
  PCTFREE 10 PCTUSED 40 INITRANS 1 MAXTRANS 255 
 NOCOMPRESS LOGGING
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_DATA" ;
  GRANT FLASHBACK ON "VRS"."REG_MARK" TO "MVIS";
  GRANT DEBUG ON "VRS"."REG_MARK" TO "MVIS";
  GRANT QUERY REWRITE ON "VRS"."REG_MARK" TO "MVIS";
  GRANT ON COMMIT REFRESH ON "VRS"."REG_MARK" TO "MVIS";
  GRANT REFERENCES ON "VRS"."REG_MARK" TO "MVIS";
  GRANT INDEX ON "VRS"."REG_MARK" TO "MVIS";
  GRANT ALTER ON "VRS"."REG_MARK" TO "MVIS";
  GRANT SELECT ON "VRS"."REG_MARK" TO "USER_INSP";
  GRANT DELETE ON "VRS"."REG_MARK" TO "MVIS";
  GRANT SELECT ON "VRS"."REG_MARK" TO "MVIS";
  GRANT UPDATE ON "VRS"."REG_MARK" TO "MVIS";
  GRANT INSERT ON "VRS"."REG_MARK" TO "MVIS";
--------------------------------------------------------
--  DDL for Table REG_MODEL
--------------------------------------------------------

  CREATE TABLE "VRS"."REG_MODEL" 
   (	"ID" NUMBER(38,0), 
	"NAME" VARCHAR2(100 BYTE), 
	"MARK_ID" NUMBER(38,0), 
	"STATUS" NUMBER(1,0), 
	"CREATED_BY" NUMBER(38,0), 
	"CREATED_DATE" DATE, 
	"UPDATED_BY" NUMBER(38,0), 
	"UPDATED_DATE" DATE, 
	"OLD_ID" NUMBER(*,0), 
	"OLD_TYPE_ID" NUMBER(38,0)
   ) SEGMENT CREATION IMMEDIATE 
  PCTFREE 10 PCTUSED 40 INITRANS 1 MAXTRANS 255 
 NOCOMPRESS LOGGING
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_DATA" ;
  GRANT FLASHBACK ON "VRS"."REG_MODEL" TO "MVIS";
  GRANT DEBUG ON "VRS"."REG_MODEL" TO "MVIS";
  GRANT QUERY REWRITE ON "VRS"."REG_MODEL" TO "MVIS";
  GRANT ON COMMIT REFRESH ON "VRS"."REG_MODEL" TO "MVIS";
  GRANT REFERENCES ON "VRS"."REG_MODEL" TO "MVIS";
  GRANT INDEX ON "VRS"."REG_MODEL" TO "MVIS";
  GRANT ALTER ON "VRS"."REG_MODEL" TO "MVIS";
  GRANT SELECT ON "VRS"."REG_MODEL" TO "USER_INSP";
  GRANT DELETE ON "VRS"."REG_MODEL" TO "MVIS";
  GRANT SELECT ON "VRS"."REG_MODEL" TO "MVIS" WITH GRANT OPTION;
  GRANT UPDATE ON "VRS"."REG_MODEL" TO "MVIS";
  GRANT INSERT ON "VRS"."REG_MODEL" TO "MVIS";
--------------------------------------------------------
--  DDL for Table REG_MODIPICACE
--------------------------------------------------------

  CREATE TABLE "VRS"."REG_MODIPICACE" 
   (	"ID" NUMBER(38,0), 
	"VIN_NO" VARCHAR2(20 BYTE), 
	"MODEL_ID" NUMBER(38,0), 
	"VEHICLE_TYPE_ID" NUMBER(38,0), 
	"CLASSIFICATION_ID" NUMBER(38,0), 
	"AXLE_COUNT" NUMBER(10,0), 
	"TOTAL_WEIGHT" NUMBER(20,2), 
	"SEAT_COUNT" NUMBER(10,0), 
	"DOOR_COUNT" NUMBER(10,0), 
	"MAX_LOAD" NUMBER(20,2), 
	"OWN_WEIGHT" NUMBER(20,0), 
	"HEIGHT" NUMBER(20,0), 
	"WIDTH" NUMBER(20,0), 
	"LENGTH" NUMBER(20,0), 
	"MODIFICACE_NAME" VARCHAR2(50 BYTE), 
	"STATUS" NUMBER(1,0), 
	"CREATED_BY" NUMBER(38,0), 
	"CREATED_DATE" DATE, 
	"UPDATED_BY" NUMBER(38,0), 
	"UPDATED_DATE" DATE, 
	"IS_HYBRID" NUMBER(2,0), 
	"ENGINE_MODEL_ID" NUMBER(38,0)
   ) SEGMENT CREATION IMMEDIATE 
  PCTFREE 10 PCTUSED 40 INITRANS 1 MAXTRANS 255 
 NOCOMPRESS LOGGING
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_DATA" ;
  GRANT FLASHBACK ON "VRS"."REG_MODIPICACE" TO "MVIS";
  GRANT DEBUG ON "VRS"."REG_MODIPICACE" TO "MVIS";
  GRANT QUERY REWRITE ON "VRS"."REG_MODIPICACE" TO "MVIS";
  GRANT ON COMMIT REFRESH ON "VRS"."REG_MODIPICACE" TO "MVIS";
  GRANT REFERENCES ON "VRS"."REG_MODIPICACE" TO "MVIS";
  GRANT INDEX ON "VRS"."REG_MODIPICACE" TO "MVIS";
  GRANT ALTER ON "VRS"."REG_MODIPICACE" TO "MVIS";
  GRANT SELECT ON "VRS"."REG_MODIPICACE" TO "USER_INSP";
  GRANT DELETE ON "VRS"."REG_MODIPICACE" TO "MVIS";
  GRANT SELECT ON "VRS"."REG_MODIPICACE" TO "MVIS" WITH GRANT OPTION;
  GRANT UPDATE ON "VRS"."REG_MODIPICACE" TO "MVIS";
  GRANT INSERT ON "VRS"."REG_MODIPICACE" TO "MVIS";
--------------------------------------------------------
--  DDL for Table REG_PLATENUMBER_SAVE
--------------------------------------------------------

  CREATE TABLE "VRS"."REG_PLATENUMBER_SAVE" 
   (	"ID" NUMBER GENERATED BY DEFAULT AS IDENTITY MINVALUE 1 MAXVALUE 9999999999999999999999999999 INCREMENT BY 1 START WITH 15517 CACHE 20 NOORDER  NOCYCLE  NOKEEP  NOSCALE , 
	"VEHICLE_ID" NUMBER(19,0), 
	"OWNER_ID" NUMBER(19,0), 
	"ARCHIVE_NUMBER" VARCHAR2(30 BYTE), 
	"IS_DELETE" NUMBER(1,0) DEFAULT 0, 
	"IS_ACTIVE" NUMBER(1,0) DEFAULT 1, 
	"PLATE_NO" VARCHAR2(20 BYTE), 
	"CUSTOMER_REGNUM" VARCHAR2(100 BYTE), 
	"CUSTOMER_LASTNAME" VARCHAR2(100 BYTE), 
	"CUSTOMER_FIRSTNAME" VARCHAR2(120 BYTE), 
	"CUSTOMER_PHONE" VARCHAR2(100 BYTE), 
	"BEGIN_DATE" TIMESTAMP (6), 
	"END_DATE" TIMESTAMP (6), 
	"UPDATED_BY" NUMBER(19,0), 
	"UPDATE_DATE" DATE, 
	"DELETED_BY" NUMBER(19,0), 
	"DELETE_DATE" DATE, 
	"CREATED_BY" NUMBER(19,0), 
	"CREATE_DATE" DATE, 
	"SMS_UID" VARCHAR2(40 BYTE), 
	"SMS_STATUS" VARCHAR2(15 BYTE), 
	"SMS_SEND_DATE" DATE, 
	"EXTEND_COUNT" NUMBER
   ) SEGMENT CREATION IMMEDIATE 
  PCTFREE 10 PCTUSED 40 INITRANS 1 MAXTRANS 255 
 NOCOMPRESS LOGGING
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "USERS" ;
  GRANT INSERT ON "VRS"."REG_PLATENUMBER_SAVE" TO "MVIS";
  GRANT SELECT ON "VRS"."REG_PLATENUMBER_SAVE" TO "MVIS";
  GRANT UPDATE ON "VRS"."REG_PLATENUMBER_SAVE" TO "MVIS";
  GRANT SELECT ON "VRS"."REG_PLATENUMBER_SAVE" TO "USER_EMONGOLIA";
  GRANT INSERT ON "VRS"."REG_PLATENUMBER_SAVE" TO "USER_EMONGOL";
  GRANT SELECT ON "VRS"."REG_PLATENUMBER_SAVE" TO "USER_EMONGOL";
  GRANT UPDATE ON "VRS"."REG_PLATENUMBER_SAVE" TO "USER_EMONGOL";
--------------------------------------------------------
--  DDL for Table REG_PLATENUMBER_SAVE_ORDER
--------------------------------------------------------

  CREATE TABLE "VRS"."REG_PLATENUMBER_SAVE_ORDER" 
   (	"ID" NUMBER(10,0), 
	"PLATE_NO" VARCHAR2(20 BYTE), 
	"CABIN" VARCHAR2(50 BYTE), 
	"CUSTOMER_REGNUM" VARCHAR2(100 BYTE), 
	"CUSTOMER_LASTNAME" VARCHAR2(100 BYTE), 
	"CUSTOMER_FIRSTNAME" VARCHAR2(120 BYTE), 
	"CREATED_BY" NUMBER(10,0), 
	"CREATE_DATE" DATE, 
	"UPDATED_BY" NUMBER(10,0), 
	"UPDATE_DATE" DATE
   ) SEGMENT CREATION IMMEDIATE 
  PCTFREE 10 PCTUSED 40 INITRANS 1 MAXTRANS 255 
 NOCOMPRESS LOGGING
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "USERS" ;
--------------------------------------------------------
--  DDL for Table REG_REFERENCE_LOG
--------------------------------------------------------

  CREATE TABLE "VRS"."REG_REFERENCE_LOG" 
   (	"ID" NUMBER(32,0), 
	"REF_TYPE" NUMBER, 
	"TYPE_ID" NUMBER, 
	"USER_TYPE_ID" NUMBER, 
	"USER_ID" NUMBER, 
	"DOCNUMBER" VARCHAR2(250 BYTE), 
	"VEHICLE_COUNT" NUMBER, 
	"REQUEST_TYPE" NUMBER, 
	"REQUEST_NAME" VARCHAR2(250 BYTE), 
	"DESCRIPTION" VARCHAR2(250 BYTE), 
	"CREATEDBY" NUMBER, 
	"CREATEDDATE" TIMESTAMP (6), 
	"MODIFIEDBY" NUMBER, 
	"MODIFIEDDATE" TIMESTAMP (6)
   ) SEGMENT CREATION IMMEDIATE 
  PCTFREE 10 PCTUSED 40 INITRANS 1 MAXTRANS 255 
 NOCOMPRESS LOGGING
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_DATA" ;
--------------------------------------------------------
--  DDL for Table REG_RFID_TAG
--------------------------------------------------------

  CREATE TABLE "VRS"."REG_RFID_TAG" 
   (	"ID" NUMBER, 
	"VEHICLE_ID" NUMBER, 
	"SERIAL_NUMBER" VARCHAR2(45 BYTE), 
	"TID" VARCHAR2(45 BYTE), 
	"EPC" VARCHAR2(45 BYTE), 
	"QRCODE" VARCHAR2(45 BYTE), 
	"IS_INCONSISTENT" NUMBER(1,0) DEFAULT 0, 
	"NOTE" NVARCHAR2(450), 
	"PHONE_NUMBER" VARCHAR2(20 BYTE), 
	"IS_ACTIVE" NUMBER(1,0), 
	"IS_DELETED" NUMBER(1,0), 
	"CREATED_BY" NUMBER, 
	"CREATED_DATE" DATE, 
	"UPDATED_BY" NUMBER, 
	"UPDATED_DATE" DATE, 
	"DELETED_BY" NUMBER(*,0), 
	"DELETED_DATE" DATE, 
	"STATUS" NUMBER(1,0) DEFAULT 1
   ) SEGMENT CREATION IMMEDIATE 
  PCTFREE 10 PCTUSED 40 INITRANS 1 MAXTRANS 255 
 NOCOMPRESS LOGGING
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_DATA" ;
  GRANT INSERT ON "VRS"."REG_RFID_TAG" TO "USER_INSP";
  GRANT SELECT ON "VRS"."REG_RFID_TAG" TO "USER_INSP";
  GRANT UPDATE ON "VRS"."REG_RFID_TAG" TO "USER_INSP";
--------------------------------------------------------
--  DDL for Table REG_RFID_TAG_PHOTO
--------------------------------------------------------

  CREATE TABLE "VRS"."REG_RFID_TAG_PHOTO" 
   (	"ID" NUMBER, 
	"RFID_TAG_ID" NUMBER, 
	"URL" VARCHAR2(150 BYTE), 
	"IS_DELETED" NUMBER(1,0) DEFAULT 0, 
	"DELETED_BY" NUMBER, 
	"DELETED_DATE" DATE
   ) SEGMENT CREATION DEFERRED 
  PCTFREE 10 PCTUSED 40 INITRANS 1 MAXTRANS 255 
 NOCOMPRESS LOGGING
  TABLESPACE "USERS" ;
  GRANT INSERT ON "VRS"."REG_RFID_TAG_PHOTO" TO "USER_INSP";
  GRANT SELECT ON "VRS"."REG_RFID_TAG_PHOTO" TO "USER_INSP";
  GRANT UPDATE ON "VRS"."REG_RFID_TAG_PHOTO" TO "USER_INSP";
--------------------------------------------------------
--  DDL for Table REG_STATUS
--------------------------------------------------------

  CREATE TABLE "VRS"."REG_STATUS" 
   (	"ID" NUMBER(10,0), 
	"NAME" VARCHAR2(255 BYTE)
   ) SEGMENT CREATION IMMEDIATE 
  PCTFREE 10 PCTUSED 40 INITRANS 1 MAXTRANS 255 
 NOCOMPRESS LOGGING
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_DATA" ;
  GRANT SELECT ON "VRS"."REG_STATUS" TO "MVIS";
--------------------------------------------------------
--  DDL for Table REG_TORGUULI
--------------------------------------------------------

  CREATE TABLE "VRS"."REG_TORGUULI" 
   (	"ID" NUMBER(38,0), 
	"PLATE_NO" NVARCHAR2(50), 
	"CABIN_NO" NVARCHAR2(50), 
	"Zorchil" NUMBER(20,0), 
	"SUMMARY" FLOAT(126)
   ) SEGMENT CREATION IMMEDIATE 
  PCTFREE 10 PCTUSED 40 INITRANS 1 MAXTRANS 255 
 NOCOMPRESS LOGGING
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "USERS" ;
--------------------------------------------------------
--  DDL for Table REG_VEHICLE
--------------------------------------------------------

  CREATE TABLE "VRS"."REG_VEHICLE" 
   (	"ID" NUMBER(38,0), 
	"PLATE_NO" NVARCHAR2(50), 
	"CABIN_NO" NVARCHAR2(50), 
	"ENGINE_NO" NVARCHAR2(50), 
	"COLOR_ID" NUMBER(38,0), 
	"CERTIFICATE_NO" NVARCHAR2(50), 
	"IMPORT_DATE" DATE, 
	"DECLARATION_NO" NVARCHAR2(50), 
	"MODEL_ID" NUMBER(38,0), 
	"SPECIAL_ID" NUMBER(38,0), 
	"BUILD_YEAR" NUMBER(18,0), 
	"BUILD_MONTH" NUMBER(18,0), 
	"PAR_TYPE_ID" NUMBER(38,0), 
	"OWNER_ID" NUMBER(38,0), 
	"ARCHIVE_NO" NVARCHAR2(50), 
	"FIRST_ARCHIVE_NO" NVARCHAR2(50), 
	"PAGE_COUNT" NUMBER(18,0), 
	"DESCRIPTION" NVARCHAR2(2000), 
	"IS_ENABLED" NUMBER(1,0) DEFAULT 1, 
	"CREATED_BY" NUMBER(38,0), 
	"CREATED_DATE" DATE, 
	"UPDATED_BY" NUMBER(38,0), 
	"UPDATED_DATE" DATE, 
	"IS_STOLEN" NUMBER(10,0), 
	"IS_WARNING" NUMBER(10,0), 
	"WHEEL_ID" NUMBER(10,0), 
	"STEERING_TYPE_ID" NUMBER(10,0), 
	"ENGINE_MODEL_ID" NUMBER(10,0), 
	"PAR_MARKER_ID" NUMBER(10,0), 
	"STATUS" NUMBER(38,0), 
	"IS_PENDING" NUMBER(18,0), 
	"OLD_PROVINCE_ID" NUMBER(18,0), 
	"PROVINCE_ID" NUMBER(18,0), 
	"FOR_TAX" NUMBER(18,0), 
	"OWNER1_ID" NUMBER(38,0), 
	"INS_CREATED_BY" NUMBER(38,0), 
	"INS_CREATED_DATE" DATE, 
	"INS_UPDATED_BY" NUMBER(38,0), 
	"INS_UPDATED_DATE" DATE, 
	"TID" VARCHAR2(40 BYTE), 
	"IS_CERT_REVOKE" NUMBER(1,0) DEFAULT 0, 
	"EXHAUST_NO" VARCHAR2(10 BYTE), 
	"IMPORT_ODOMETER" NUMBER(8,0), 
	"IMPORT_COUNTRY" VARCHAR2(50 BYTE)
   ) SEGMENT CREATION IMMEDIATE 
  PCTFREE 10 PCTUSED 40 INITRANS 1 MAXTRANS 255 
 NOCOMPRESS LOGGING
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_DATA" ;
  GRANT FLASHBACK ON "VRS"."REG_VEHICLE" TO "MVIS";
  GRANT DEBUG ON "VRS"."REG_VEHICLE" TO "MVIS";
  GRANT QUERY REWRITE ON "VRS"."REG_VEHICLE" TO "MVIS";
  GRANT ON COMMIT REFRESH ON "VRS"."REG_VEHICLE" TO "MVIS";
  GRANT REFERENCES ON "VRS"."REG_VEHICLE" TO "MVIS";
  GRANT INDEX ON "VRS"."REG_VEHICLE" TO "MVIS";
  GRANT ALTER ON "VRS"."REG_VEHICLE" TO "MVIS";
  GRANT DELETE ON "VRS"."REG_VEHICLE" TO "MVIS";
  GRANT SELECT ON "VRS"."REG_VEHICLE" TO "SYSTEM" WITH GRANT OPTION;
  GRANT SELECT ON "VRS"."REG_VEHICLE" TO "MVIS" WITH GRANT OPTION;
  GRANT UPDATE ON "VRS"."REG_VEHICLE" TO "MVIS";
  GRANT INSERT ON "VRS"."REG_VEHICLE" TO "MVIS";
  GRANT SELECT ON "VRS"."REG_VEHICLE" TO "USER_NDC";
  GRANT SELECT ON "VRS"."REG_VEHICLE" TO "USER_ZHUT";
  GRANT SELECT ON "VRS"."REG_VEHICLE" TO "USER_INSP";
  GRANT SELECT ON "VRS"."REG_VEHICLE" TO "USER_EMONGOL";
  GRANT UPDATE ON "VRS"."REG_VEHICLE" TO "USER_EMONGOL";
--------------------------------------------------------
--  DDL for Table REG_VEHICLE_ARCHIVE
--------------------------------------------------------

  CREATE TABLE "VRS"."REG_VEHICLE_ARCHIVE" 
   (	"ID" NUMBER(*,0), 
	"VEHICLE_ID" NUMBER(*,0), 
	"PLATE_NO" NVARCHAR2(20), 
	"CABIN_NO" NVARCHAR2(50), 
	"ENGINE_NO" NVARCHAR2(50), 
	"COLOR_ID" NUMBER(*,0), 
	"CERTIFICATE_NO" NVARCHAR2(50), 
	"IMPORT_DATE" DATE, 
	"DECLARATION_NO" NVARCHAR2(50), 
	"MODEL_ID" NUMBER(*,0), 
	"SPECIAL_ID" NUMBER(*,0), 
	"BUILD_YEAR" NUMBER(*,0), 
	"BUILD_MONTH" NUMBER(*,0), 
	"PAR_TYPE_ID" NUMBER(*,0), 
	"OWNER_ID" NUMBER(*,0), 
	"ARCHIVE_NO" NVARCHAR2(50), 
	"FIRST_ARCHIVE_NO" NVARCHAR2(50), 
	"PAGE_COUNT" NUMBER(*,0), 
	"DESCRIPTION" NVARCHAR2(1000), 
	"IS_ENABLED" NUMBER(*,0), 
	"CREATED_BY" NUMBER(*,0), 
	"CREATED_DATE" DATE, 
	"UPDATED_BY" NUMBER(*,0), 
	"UPDATED_DATE" DATE, 
	"IS_STOLEN" NUMBER(*,0), 
	"IS_WARNING" NUMBER(*,0), 
	"WHEEL_ID" NUMBER(*,0), 
	"STEERING_TYPE_ID" NUMBER(*,0), 
	"ENGINE_MODEL_ID" NUMBER(*,0), 
	"PAR_MARKER_ID" NUMBER(*,0), 
	"STATUS" NUMBER(*,0), 
	"IS_PENDING" NUMBER(*,0), 
	"OLD_PROVINCE_ID" NUMBER(*,0), 
	"PROVINCE_ID" NUMBER(*,0), 
	"VIN_NO" NVARCHAR2(50), 
	"COLOR_NAME" NVARCHAR2(50), 
	"COUNTRY_ID" NUMBER(*,0), 
	"MARK_ID" NUMBER(*,0), 
	"MARK_NAME" NVARCHAR2(50), 
	"MODEL_NAME" NVARCHAR2(50), 
	"SERVICE_ID" NUMBER(*,0), 
	"SERVICE_NAME" NVARCHAR2(50), 
	"ARCHIVE_DEPARTMENT" NUMBER(*,0), 
	"ARCHIVE_ABBR" NVARCHAR2(50), 
	"OWNER1_ID" NUMBER(*,0), 
	"INSERT_CERTIFICATE_NO" NVARCHAR2(50), 
	"INSERT_ARCHIVE_NO" NVARCHAR2(50), 
	"INSERT_PLATE_NO" NVARCHAR2(20), 
	"INSERT_SERVICE_ID" NUMBER(*,0), 
	"INSERT_MODEL_ID" NUMBER(*,0), 
	"INSERT_OWNER_ID" NUMBER(*,0), 
	"INSERT_PAGE_COUNT" NUMBER, 
	"INS_CREATED_BY" NUMBER, 
	"INS_CREATED_DATE" DATE, 
	"INSERT_FINGER" NUMBER(3,0), 
	"INSERT_FINGER_DESCRIPTION" VARCHAR2(1000 BYTE), 
	"INSERT_DESCRIPTION" VARCHAR2(1000 BYTE)
   ) SEGMENT CREATION IMMEDIATE 
  PCTFREE 10 PCTUSED 40 INITRANS 1 MAXTRANS 255 
 NOCOMPRESS LOGGING
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_DATA" ;
  GRANT SELECT ON "VRS"."REG_VEHICLE_ARCHIVE" TO "MVIS";
  GRANT SELECT ON "VRS"."REG_VEHICLE_ARCHIVE" TO "USER_NDC";
  GRANT SELECT ON "VRS"."REG_VEHICLE_ARCHIVE" TO "USER_INSP";
  GRANT SELECT ON "VRS"."REG_VEHICLE_ARCHIVE" TO "USER_ZHUT";
  GRANT INSERT ON "VRS"."REG_VEHICLE_ARCHIVE" TO "USER_EMONGOL";
  GRANT SELECT ON "VRS"."REG_VEHICLE_ARCHIVE" TO "USER_EMONGOL";
  GRANT UPDATE ON "VRS"."REG_VEHICLE_ARCHIVE" TO "USER_EMONGOL";
--------------------------------------------------------
--  DDL for Table REG_VEHICLE_INSP_ARCHIVE
--------------------------------------------------------

  CREATE TABLE "VRS"."REG_VEHICLE_INSP_ARCHIVE" 
   (	"ID" NUMBER, 
	"VEHICLE_ID" NUMBER, 
	"PLATE_NO" VARCHAR2(20 BYTE), 
	"CABIN_NO" VARCHAR2(30 BYTE), 
	"DECLARATION_NO" VARCHAR2(30 BYTE), 
	"BUILD_YEAR" NUMBER, 
	"IMPORT_DATE" DATE, 
	"COLOR_NAME" VARCHAR2(100 BYTE), 
	"PURPOSE_NAME" VARCHAR2(100 BYTE), 
	"BODY_SIZE" VARCHAR2(50 BYTE), 
	"WEIGHT" VARCHAR2(50 BYTE), 
	"ASD_COUNT" VARCHAR2(20 BYTE), 
	"CREATED_BY" NUMBER, 
	"CREATED_DATE" DATE, 
	"OLD_ID" NUMBER, 
	"MODEL_ID" NUMBER, 
	"CREATED_NAME" VARCHAR2(30 BYTE), 
	"BRANCH_NAME" VARCHAR2(100 BYTE), 
	"SERVICE_ID" NUMBER, 
	"ENGINE_MODEL_NAME" VARCHAR2(100 BYTE), 
	"SPECIAL_NAME" VARCHAR2(100 BYTE), 
	"EXHAUST_NO" VARCHAR2(40 BYTE)
   ) SEGMENT CREATION IMMEDIATE 
  PCTFREE 10 PCTUSED 40 INITRANS 1 MAXTRANS 255 
 NOCOMPRESS LOGGING
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_DATA" ;
  GRANT FLASHBACK ON "VRS"."REG_VEHICLE_INSP_ARCHIVE" TO "MVIS";
  GRANT DEBUG ON "VRS"."REG_VEHICLE_INSP_ARCHIVE" TO "MVIS";
  GRANT QUERY REWRITE ON "VRS"."REG_VEHICLE_INSP_ARCHIVE" TO "MVIS";
  GRANT ON COMMIT REFRESH ON "VRS"."REG_VEHICLE_INSP_ARCHIVE" TO "MVIS";
  GRANT REFERENCES ON "VRS"."REG_VEHICLE_INSP_ARCHIVE" TO "MVIS";
  GRANT INDEX ON "VRS"."REG_VEHICLE_INSP_ARCHIVE" TO "MVIS";
  GRANT ALTER ON "VRS"."REG_VEHICLE_INSP_ARCHIVE" TO "MVIS";
  GRANT DELETE ON "VRS"."REG_VEHICLE_INSP_ARCHIVE" TO "MVIS";
  GRANT UPDATE ON "VRS"."REG_VEHICLE_INSP_ARCHIVE" TO "MVIS";
  GRANT SELECT ON "VRS"."REG_VEHICLE_INSP_ARCHIVE" TO "MVIS";
  GRANT INSERT ON "VRS"."REG_VEHICLE_INSP_ARCHIVE" TO "MVIS";
--------------------------------------------------------
--  DDL for Table REG_VEHICLE_OWNER1SHIP
--------------------------------------------------------

  CREATE TABLE "VRS"."REG_VEHICLE_OWNER1SHIP" 
   (	"ID" NUMBER GENERATED BY DEFAULT AS IDENTITY MINVALUE 1 MAXVALUE 9999999999999999999999999999 INCREMENT BY 1 START WITH 126913 CACHE 20 NOORDER  NOCYCLE  NOKEEP  NOSCALE , 
	"VEHICLE_ID" NUMBER(38,0), 
	"OWNER1_ID" NUMBER(38,0), 
	"START_DATE" DATE, 
	"END_DATE" DATE, 
	"OWNERSHIP_TYPE_ID" NUMBER(38,0), 
	"STATUS" NUMBER(10,0), 
	"CREATED_BY" NUMBER(19,0), 
	"CREATED_DATE" DATE, 
	"UPDATED_BY" NUMBER(19,0), 
	"UPDATED_DATE" DATE, 
	"END_OWNER1_ID" NUMBER(19,0), 
	"DELETED_AT" DATE, 
	"COLUMN1" VARCHAR2(20 BYTE)
   ) SEGMENT CREATION IMMEDIATE 
  PCTFREE 10 PCTUSED 40 INITRANS 1 MAXTRANS 255 
 NOCOMPRESS LOGGING
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "USERS" ;
--------------------------------------------------------
--  DDL for Table REG_VEHICLE_OWNERSHIP
--------------------------------------------------------

  CREATE TABLE "VRS"."REG_VEHICLE_OWNERSHIP" 
   (	"ID" NUMBER(38,0), 
	"VEHICLE_ID" NUMBER(38,0), 
	"OWNER_ID" NUMBER(38,0), 
	"START_DATE" DATE, 
	"END_DATE" DATE, 
	"OWNERSHIP_TYPE_ID" NUMBER(38,0), 
	"STATUS" NUMBER(10,0), 
	"CREATED_BY" NUMBER(38,0), 
	"CREATED_DATE" DATE, 
	"UPDATED_BY" NUMBER(38,0), 
	"UPDATED_DATE" DATE, 
	"END_OWNER_ID" NUMBER, 
	"COLUMN1" VARCHAR2(20 BYTE)
   ) SEGMENT CREATION IMMEDIATE 
  PCTFREE 10 PCTUSED 40 INITRANS 1 MAXTRANS 255 
 NOCOMPRESS LOGGING
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_DATA" ;
  GRANT SELECT ON "VRS"."REG_VEHICLE_OWNERSHIP" TO "MVIS";
  GRANT SELECT ON "VRS"."REG_VEHICLE_OWNERSHIP" TO "USER_INSP";
  GRANT SELECT ON "VRS"."REG_VEHICLE_OWNERSHIP" TO "USER_NDC";
  GRANT INSERT ON "VRS"."REG_VEHICLE_OWNERSHIP" TO "USER_EMONGOL";
  GRANT SELECT ON "VRS"."REG_VEHICLE_OWNERSHIP" TO "USER_EMONGOL";
  GRANT UPDATE ON "VRS"."REG_VEHICLE_OWNERSHIP" TO "USER_EMONGOL";
--------------------------------------------------------
--  DDL for Table REG_VEHICLE_TYPE
--------------------------------------------------------

  CREATE TABLE "VRS"."REG_VEHICLE_TYPE" 
   (	"ID" NUMBER(38,0), 
	"NAME" VARCHAR2(500 BYTE), 
	"DECELERATION" NUMBER(20,2) DEFAULT 0, 
	"TREADDEPTH" NUMBER(20,2) DEFAULT 0, 
	"FREEOPERATION" NUMBER(20,0) DEFAULT 0, 
	"STATUS" NUMBER(1,0) DEFAULT 1, 
	"CREATED_BY" NUMBER(38,0), 
	"CREATED_DATE" DATE, 
	"UPDATED_BY" NUMBER(38,0), 
	"UPDATED_DATE" DATE, 
	"PURPOSE_ID" NUMBER(*,0), 
	"OLD_ID" NUMBER, 
	"BASETYPE" NUMBER(2,0), 
	"NAMEENG" VARCHAR2(50 BYTE), 
	"DESCRIPTION" VARCHAR2(50 BYTE)
   ) SEGMENT CREATION IMMEDIATE 
  PCTFREE 10 PCTUSED 40 INITRANS 1 MAXTRANS 255 
 NOCOMPRESS LOGGING
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_DATA" ;
  GRANT FLASHBACK ON "VRS"."REG_VEHICLE_TYPE" TO "MVIS";
  GRANT DEBUG ON "VRS"."REG_VEHICLE_TYPE" TO "MVIS";
  GRANT QUERY REWRITE ON "VRS"."REG_VEHICLE_TYPE" TO "MVIS";
  GRANT ON COMMIT REFRESH ON "VRS"."REG_VEHICLE_TYPE" TO "MVIS";
  GRANT REFERENCES ON "VRS"."REG_VEHICLE_TYPE" TO "MVIS";
  GRANT INDEX ON "VRS"."REG_VEHICLE_TYPE" TO "MVIS";
  GRANT ALTER ON "VRS"."REG_VEHICLE_TYPE" TO "MVIS";
  GRANT SELECT ON "VRS"."REG_VEHICLE_TYPE" TO "USER_INSP";
  GRANT DELETE ON "VRS"."REG_VEHICLE_TYPE" TO "MVIS";
  GRANT SELECT ON "VRS"."REG_VEHICLE_TYPE" TO "MVIS" WITH GRANT OPTION;
  GRANT UPDATE ON "VRS"."REG_VEHICLE_TYPE" TO "MVIS";
  GRANT INSERT ON "VRS"."REG_VEHICLE_TYPE" TO "MVIS";
--------------------------------------------------------
--  DDL for Table SERIES
--------------------------------------------------------

  CREATE TABLE "VRS"."SERIES" 
   (	"ID" NUMBER(19,0), 
	"CREATE_DATE" TIMESTAMP (6), 
	"NAME" VARCHAR2(255 CHAR), 
	"UPDATE_DATE" TIMESTAMP (6), 
	"CREATED_BY_ID" NUMBER(19,0), 
	"UPDATED_BY_ID" NUMBER(19,0), 
	"TYPE" NUMBER(10,0), 
	"PROVINCE_ID" NUMBER(19,0), 
	"IS_DUPLICATE" NUMBER, 
	"IS_OLD" NUMBER, 
	"IS_CHECK_ADDRESS" NUMBER
   ) SEGMENT CREATION IMMEDIATE 
  PCTFREE 10 PCTUSED 40 INITRANS 1 MAXTRANS 255 
 NOCOMPRESS LOGGING
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_DATA" ;
  GRANT SELECT ON "VRS"."SERIES" TO "USER_INSP";
  GRANT SELECT ON "VRS"."SERIES" TO "USER_ZHUT";
  GRANT SELECT ON "VRS"."SERIES" TO "USER_EMONGOL";
--------------------------------------------------------
--  DDL for Table SERIES_INTERVAL
--------------------------------------------------------

  CREATE TABLE "VRS"."SERIES_INTERVAL" 
   (	"ID" NUMBER(19,0), 
	"CREATE_DATE" TIMESTAMP (6), 
	"NAME" VARCHAR2(20 CHAR), 
	"UPDATE_DATE" TIMESTAMP (6), 
	"FROM_NUMBER" NUMBER(10,0), 
	"TO_NUMBER" NUMBER(10,0), 
	"CREATED_BY_ID" NUMBER(19,0), 
	"UPDATED_BY_ID" NUMBER(19,0), 
	"LOCAL_USER_ID" NUMBER(19,0), 
	"SERIES_ID" NUMBER(19,0), 
	"IS_LOCAL" NUMBER(1,0), 
	"IS_ORDER" NUMBER(1,0), 
	"IS_HIDDEN" NUMBER(1,0), 
	"IS_OPENED" NUMBER(1,0), 
	"IS_AUTO" NUMBER(1,0), 
	"TYPE" NUMBER(10,0)
   ) SEGMENT CREATION IMMEDIATE 
  PCTFREE 10 PCTUSED 40 INITRANS 1 MAXTRANS 255 
 NOCOMPRESS LOGGING
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_DATA" ;
  GRANT SELECT ON "VRS"."SERIES_INTERVAL" TO "USER_ZHUT";
  GRANT SELECT ON "VRS"."SERIES_INTERVAL" TO "USER_EMONGOL";
--------------------------------------------------------
--  DDL for Table SERIES_NUMBER
--------------------------------------------------------

  CREATE TABLE "VRS"."SERIES_NUMBER" 
   (	"ID" NUMBER(19,0), 
	"CREATE_DATE" TIMESTAMP (6), 
	"NAME" VARCHAR2(20 CHAR), 
	"UPDATE_DATE" TIMESTAMP (6), 
	"IS_GIVEN" NUMBER(1,0), 
	"IS_HIDDEN" NUMBER(1,0), 
	"IS_LOCAL" NUMBER(1,0), 
	"IS_OPENED" NUMBER(1,0), 
	"LIMITED_DAY" NUMBER(10,0), 
	"NO" NUMBER(10,0), 
	"ORDER_DATE" TIMESTAMP (6), 
	"ORDER_USER" VARCHAR2(10 CHAR), 
	"TYPE" NUMBER(10,0), 
	"CREATED_BY_ID" NUMBER(19,0), 
	"UPDATED_BY_ID" NUMBER(19,0), 
	"LOCAL_USER_ID" NUMBER(19,0), 
	"SERIES_ID" NUMBER(19,0), 
	"VEHICLE_ID" NUMBER(19,0), 
	"IS_ORDER" NUMBER(1,0), 
	"IS_AUTO" NUMBER(1,0), 
	"SHOW_DATE" VARCHAR2(1000 BYTE), 
	"ORDER_CABIN" VARCHAR2(20 CHAR), 
	"IP_ADDRESS" VARCHAR2(50 CHAR), 
	"IP_INFO" LONG, 
	"WEEKEND" NUMBER(1,0), 
	"ISAUCTION" NUMBER(1,0) DEFAULT 0, 
	"IS_SAVE" NUMBER(19,0) DEFAULT 0
   ) SEGMENT CREATION IMMEDIATE 
  PCTFREE 10 PCTUSED 40 INITRANS 1 MAXTRANS 255 
 NOCOMPRESS LOGGING
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_DATA" ;
  GRANT SELECT ON "VRS"."SERIES_NUMBER" TO "MVIS";
  GRANT SELECT ON "VRS"."SERIES_NUMBER" TO "USER_INSP";
  GRANT SELECT ON "VRS"."SERIES_NUMBER" TO "USER_ZHUT";
  GRANT SELECT ON "VRS"."SERIES_NUMBER" TO "USER_EMONGOLIA";
  GRANT SELECT ON "VRS"."SERIES_NUMBER" TO "USER_EMONGOL";
  GRANT UPDATE ON "VRS"."SERIES_NUMBER" TO "USER_EMONGOL";
--------------------------------------------------------
--  DDL for Table SERIES_REMOVAL
--------------------------------------------------------

  CREATE TABLE "VRS"."SERIES_REMOVAL" 
   (	"ID" NUMBER(19,0), 
	"CREATE_DATE" TIMESTAMP (6), 
	"NAME" VARCHAR2(255 CHAR), 
	"UPDATE_DATE" TIMESTAMP (6), 
	"CREATED_BY_ID" NUMBER(19,0), 
	"UPDATED_BY_ID" NUMBER(19,0)
   ) SEGMENT CREATION IMMEDIATE 
  PCTFREE 10 PCTUSED 40 INITRANS 1 MAXTRANS 255 
 NOCOMPRESS LOGGING
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_DATA" ;
  GRANT SELECT ON "VRS"."SERIES_REMOVAL" TO "USER_ZHUT";
--------------------------------------------------------
--  DDL for Table SYSTEM_ARCHIVE
--------------------------------------------------------

  CREATE TABLE "VRS"."SYSTEM_ARCHIVE" 
   (	"ID" NUMBER(10,0), 
	"PROVINCEID" NUMBER(10,0), 
	"DEPARTMENTID" NUMBER(10,0), 
	"ARCHIVE" VARCHAR2(150 BYTE), 
	"ABBR" VARCHAR2(50 BYTE), 
	"CREATEDBY" NUMBER(19,0), 
	"MODIFIEDBY" NUMBER(19,0), 
	"CREATEDDATE" TIMESTAMP (6), 
	"MODIFIEDDATE" TIMESTAMP (6), 
	"DELETED_AT" TIMESTAMP (6), 
	"IS_TYPE" NUMBER DEFAULT 1
   ) SEGMENT CREATION IMMEDIATE 
  PCTFREE 10 PCTUSED 40 INITRANS 1 MAXTRANS 255 
 NOCOMPRESS LOGGING
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_DATA" ;
  GRANT SELECT ON "VRS"."SYSTEM_ARCHIVE" TO "MVIS";
--------------------------------------------------------
--  DDL for Table SYSTEM_DEPARTMENT
--------------------------------------------------------

  CREATE TABLE "VRS"."SYSTEM_DEPARTMENT" 
   (	"ID" NUMBER(19,0), 
	"CREATEDDATE" TIMESTAMP (6), 
	"NAME" VARCHAR2(255 CHAR), 
	"MODIFIEDDATE" TIMESTAMP (6), 
	"CREATEDBY" NUMBER(19,0), 
	"MODIFIEDBY" NUMBER(19,0), 
	"DELETED_AT" TIMESTAMP (6), 
	"PROVINCE_ID" NUMBER(20,0), 
	"DEPARTMENT_TYPE" NUMBER(10,0), 
	"DEP_LICENSE_NUMBER" VARCHAR2(100 BYTE), 
	"DEP_LICENSE_START_DATE" VARCHAR2(100 BYTE), 
	"DEP_REGISTER" VARCHAR2(100 BYTE), 
	"DEP_ADDRESS" VARCHAR2(100 BYTE), 
	"DEP_PHONE" VARCHAR2(100 BYTE), 
	"DEP_DIRECTOR" VARCHAR2(100 BYTE), 
	"DEP_LICENSE_END_DATE" VARCHAR2(100 BYTE)
   ) SEGMENT CREATION IMMEDIATE 
  PCTFREE 10 PCTUSED 40 INITRANS 1 MAXTRANS 255 
 NOCOMPRESS LOGGING
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_DATA" ;
--------------------------------------------------------
--  DDL for Table SYSTEM_DEPTYPE
--------------------------------------------------------

  CREATE TABLE "VRS"."SYSTEM_DEPTYPE" 
   (	"ID" VARCHAR2(20 BYTE), 
	"NAME" VARCHAR2(100 BYTE)
   ) SEGMENT CREATION IMMEDIATE 
  PCTFREE 10 PCTUSED 40 INITRANS 1 MAXTRANS 255 
 NOCOMPRESS LOGGING
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_DATA" ;
--------------------------------------------------------
--  DDL for Table SYSTEM_DIVISIONUNIT
--------------------------------------------------------

  CREATE TABLE "VRS"."SYSTEM_DIVISIONUNIT" 
   (	"ID" NUMBER(19,0), 
	"CREATE_DATE" TIMESTAMP (6), 
	"NAME" VARCHAR2(255 CHAR), 
	"UPDATE_DATE" TIMESTAMP (6), 
	"ARCHIVE_NUMBER" VARCHAR2(255 CHAR), 
	"CREATED_BY_ID" NUMBER(19,0), 
	"UPDATED_BY_ID" NUMBER(19,0), 
	"DIVISION_ID" NUMBER(19,0), 
	"EDIT_PREF" VARCHAR2(255 CHAR), 
	"NEW_PREF" VARCHAR2(255 CHAR), 
	"MOVE_PREF" VARCHAR2(255 CHAR), 
	"DELETE_PREF" VARCHAR2(255 CHAR), 
	"OTHER_PREF" VARCHAR2(100 BYTE), 
	"ABBR" VARCHAR2(100 BYTE)
   ) SEGMENT CREATION IMMEDIATE 
  PCTFREE 10 PCTUSED 40 INITRANS 1 MAXTRANS 255 
 NOCOMPRESS LOGGING
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_DATA" ;
--------------------------------------------------------
--  DDL for Table SYSTEM_ISSUE
--------------------------------------------------------

  CREATE TABLE "VRS"."SYSTEM_ISSUE" 
   (	"ID" NUMBER, 
	"OPEN_DATE" TIMESTAMP (6), 
	"CLOSE_DATE" TIMESTAMP (6), 
	"ANSWER" VARCHAR2(2500 BYTE), 
	"QUESTION" LONG, 
	"OPEN_USER_ID" NUMBER, 
	"CLOSE_USER_ID" NUMBER, 
	"PHONE_NO" VARCHAR2(250 BYTE), 
	"STATUS" NUMBER, 
	"ANSWER_IMAGE" VARCHAR2(255 BYTE), 
	"QUESTION_IMAGE" VARCHAR2(255 BYTE)
   ) SEGMENT CREATION IMMEDIATE 
  PCTFREE 10 PCTUSED 40 INITRANS 1 MAXTRANS 255 
 NOCOMPRESS LOGGING
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_DATA" ;
--------------------------------------------------------
--  DDL for Table SYSTEM_MENU
--------------------------------------------------------

  CREATE TABLE "VRS"."SYSTEM_MENU" 
   (	"ID" NUMBER(19,0), 
	"CREATE_DATE" TIMESTAMP (6), 
	"NAME" VARCHAR2(255 CHAR), 
	"UPDATE_DATE" TIMESTAMP (6), 
	"URL" VARCHAR2(255 CHAR), 
	"CREATEDBY" NUMBER(19,0), 
	"MODIEFIEDBY" NUMBER(19,0), 
	"IS_PARENT" NUMBER(18,0), 
	"ORDR" NUMBER(18,0), 
	"ICON" VARCHAR2(400 BYTE), 
	"DESCRIPTION" VARCHAR2(250 BYTE)
   ) SEGMENT CREATION IMMEDIATE 
  PCTFREE 10 PCTUSED 40 INITRANS 1 MAXTRANS 255 
 NOCOMPRESS LOGGING
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_DATA" ;
--------------------------------------------------------
--  DDL for Table SYSTEM_PLATE_FACTORY
--------------------------------------------------------

  CREATE TABLE "VRS"."SYSTEM_PLATE_FACTORY" 
   (	"ID" NUMBER, 
	"TYPE_ID" NUMBER, 
	"PLATE_NO" VARCHAR2(20 BYTE), 
	"SERVICE_ID" NUMBER, 
	"USER_ID" NUMBER, 
	"PRINT_ID" NUMBER, 
	"IS_PRINT" NUMBER, 
	"CREATE_DATE" TIMESTAMP (6), 
	"UPDATE_DATE" TIMESTAMP (6), 
	"PLATECOLOR" NUMBER(10,0)
   ) SEGMENT CREATION IMMEDIATE 
  PCTFREE 10 PCTUSED 40 INITRANS 1 MAXTRANS 255 
 NOCOMPRESS LOGGING
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_DATA" ;
--------------------------------------------------------
--  DDL for Table SYSTEM_POSITION
--------------------------------------------------------

  CREATE TABLE "VRS"."SYSTEM_POSITION" 
   (	"ID" NUMBER(10,0), 
	"NAME" VARCHAR2(256 BYTE), 
	"CREATEDBY" NUMBER(10,0), 
	"MODIFIEDBY" NUMBER(10,0), 
	"CREATEDDATE" TIMESTAMP (6), 
	"MODIFIEDDATE" TIMESTAMP (6), 
	"DELETED_AT" TIMESTAMP (6)
   ) SEGMENT CREATION IMMEDIATE 
  PCTFREE 10 PCTUSED 40 INITRANS 1 MAXTRANS 255 
 NOCOMPRESS LOGGING
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_DATA" ;
--------------------------------------------------------
--  DDL for Table SYSTEM_POSITION_LOG
--------------------------------------------------------

  CREATE TABLE "VRS"."SYSTEM_POSITION_LOG" 
   (	"ID" NUMBER(19,0), 
	"CREATEDDATE" TIMESTAMP (6), 
	"NAME" VARCHAR2(255 CHAR), 
	"ACTION_ID" NUMBER(19,0), 
	"POSITION_ID" NUMBER(19,0), 
	"CREATEDBY" NUMBER(19,0), 
	"UPDATEDBY" NUMBER(19,0), 
	"TYPE_ID" NUMBER(38,0)
   ) SEGMENT CREATION IMMEDIATE 
  PCTFREE 10 PCTUSED 40 INITRANS 1 MAXTRANS 255 
 NOCOMPRESS LOGGING
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_DATA" ;
--------------------------------------------------------
--  DDL for Table SYSTEM_PRINTER
--------------------------------------------------------

  CREATE TABLE "VRS"."SYSTEM_PRINTER" 
   (	"ID" NUMBER(10,0), 
	"NAME" VARCHAR2(50 BYTE), 
	"X" VARCHAR2(20 BYTE), 
	"Y" VARCHAR2(20 BYTE), 
	"LINE" VARCHAR2(20 BYTE), 
	"TEXT" VARCHAR2(20 BYTE), 
	"CREATED_DATE" DATE, 
	"UPDATED_DATE" DATE
   ) SEGMENT CREATION IMMEDIATE 
  PCTFREE 10 PCTUSED 40 INITRANS 1 MAXTRANS 255 
 NOCOMPRESS LOGGING
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_DATA" ;
--------------------------------------------------------
--  DDL for Table SYSTEM_SERVICE
--------------------------------------------------------

  CREATE TABLE "VRS"."SYSTEM_SERVICE" 
   (	"ID" NUMBER(19,0), 
	"CREATEDDATE" TIMESTAMP (6), 
	"NAME" VARCHAR2(255 CHAR), 
	"MODIFIEDDATE" TIMESTAMP (6), 
	"CODE" VARCHAR2(255 CHAR), 
	"FEE" FLOAT(126), 
	"CREATEDBY" NUMBER(19,0), 
	"MODIFIEDBY" NUMBER(19,0), 
	"SERVICEPREFIX" VARCHAR2(255 BYTE), 
	"ICON" VARCHAR2(100 BYTE), 
	"VIEW_ORDER" NUMBER, 
	"DESCRIPTION" VARCHAR2(100 BYTE), 
	"IS_SHOW" NUMBER(1,0) DEFAULT 1, 
	"URL" VARCHAR2(200 BYTE), 
	"DELETED_AT" TIMESTAMP (6), 
	"GROUP_NAME" VARCHAR2(20 BYTE)
   ) SEGMENT CREATION IMMEDIATE 
  PCTFREE 10 PCTUSED 40 INITRANS 1 MAXTRANS 255 
 NOCOMPRESS LOGGING
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_DATA" ;
  GRANT SELECT ON "VRS"."SYSTEM_SERVICE" TO "MVIS";
--------------------------------------------------------
--  DDL for Table SYSTEM_USER
--------------------------------------------------------

  CREATE TABLE "VRS"."SYSTEM_USER" 
   (	"ID" NUMBER(19,0), 
	"ISACTIVE" NUMBER(1,0), 
	"CREATEDDATE" TIMESTAMP (6), 
	"FIRSTNAME" VARCHAR2(255 CHAR), 
	"LASTNAME" VARCHAR2(255 CHAR), 
	"PASSWORD" VARCHAR2(255 CHAR), 
	"MODIFIEDDATE" TIMESTAMP (6), 
	"USERNAME" VARCHAR2(255 CHAR), 
	"PROVINCEID" NUMBER(19,0), 
	"USERPOSITIONID" NUMBER(20,0), 
	"PASSWORDANOTHER" VARCHAR2(255 BYTE), 
	"USERDEPARTMENTID" NUMBER(19,0), 
	"CREATEDBY" NUMBER(19,0), 
	"MODIFIEDBY" NUMBER(19,0), 
	"DELETED_AT" TIMESTAMP (6), 
	"REMEMBER_TOKEN" VARCHAR2(100 BYTE), 
	"SESSION_ID" VARCHAR2(500 BYTE), 
	"ISATVT" NUMBER(1,0) DEFAULT 1, 
	"LAST_CHANGE_PASSWORD" TIMESTAMP (6), 
	"ISCITY" NUMBER(1,0) DEFAULT 0, 
	"API_TOKEN" VARCHAR2(255 BYTE)
   ) SEGMENT CREATION IMMEDIATE 
  PCTFREE 10 PCTUSED 40 INITRANS 1 MAXTRANS 255 
 NOCOMPRESS LOGGING
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_DATA" ;
--------------------------------------------------------
--  DDL for Table SYSTEM_USER_MENU
--------------------------------------------------------

  CREATE TABLE "VRS"."SYSTEM_USER_MENU" 
   (	"ID" NUMBER(19,0), 
	"CREATEDDATE" TIMESTAMP (6), 
	"NAME" VARCHAR2(255 CHAR), 
	"UPDATEDDATE" TIMESTAMP (6), 
	"ACTION_ID" NUMBER(19,0), 
	"POSITION_ID" NUMBER(19,0), 
	"CREATEDBY" NUMBER(19,0), 
	"UPDATEDBY" NUMBER(19,0), 
	"TYPE_ID" NUMBER(38,0)
   ) SEGMENT CREATION IMMEDIATE 
  PCTFREE 10 PCTUSED 40 INITRANS 1 MAXTRANS 255 
 NOCOMPRESS LOGGING
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_DATA" ;
--------------------------------------------------------
--  DDL for Table TEMP_LIMIT
--------------------------------------------------------

  CREATE TABLE "VRS"."TEMP_LIMIT" 
   (	"ID" NUMBER(38,0), 
	"PLATE_NO" NVARCHAR2(50)
   ) SEGMENT CREATION IMMEDIATE 
  PCTFREE 10 PCTUSED 40 INITRANS 1 MAXTRANS 255 
 NOCOMPRESS LOGGING
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "USERS" ;
--------------------------------------------------------
--  DDL for Table TRANSACTION
--------------------------------------------------------

  CREATE TABLE "VRS"."TRANSACTION" 
   (	"ID" NUMBER(38,0), 
	"ACCOUNT_NUMBER" NUMBER, 
	"INVOICE_ID" NUMBER(38,0), 
	"DESCRIPTION" NVARCHAR2(2000), 
	"RELATED_ACCOUNT" NUMBER(38,0), 
	"OWNER_NAME" NVARCHAR2(50), 
	"AMOUNT" NVARCHAR2(50), 
	"TRANSACTION_DATE" TIMESTAMP (6), 
	"TYPE" NUMBER(10,0) DEFAULT 0, 
	"ARKHIVE_NO" NVARCHAR2(50)
   ) SEGMENT CREATION IMMEDIATE 
  PCTFREE 10 PCTUSED 40 INITRANS 1 MAXTRANS 255 
 NOCOMPRESS LOGGING
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "USERS" ;
  GRANT INSERT ON "VRS"."TRANSACTION" TO "USER_INSP";
  GRANT SELECT ON "VRS"."TRANSACTION" TO "USER_INSP";
--------------------------------------------------------
--  DDL for Table VEHICLE_TYPE
--------------------------------------------------------

  CREATE TABLE "VRS"."VEHICLE_TYPE" 
   (	"ID" NUMBER(10,0), 
	"NAME" VARCHAR2(20 BYTE)
   ) SEGMENT CREATION IMMEDIATE 
  PCTFREE 10 PCTUSED 40 INITRANS 1 MAXTRANS 255 
 NOCOMPRESS LOGGING
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_DATA" ;
--------------------------------------------------------
--  DDL for View ARCHIVE_SEARCH_VIEW
--------------------------------------------------------

  CREATE OR REPLACE FORCE EDITIONABLE VIEW "VRS"."ARCHIVE_SEARCH_VIEW" ("ID", "VEHICLE_ID", "PLATE_NO", "CABIN_NO", "IS_ENABLED", "IS_PENDING", "VIN_NO", "ENGINE_NO", "COLOR_ID", "CERTIFICATE_NO", "IMPORT_DATE", "DECLARATION_NO", "MARK_ID", "MODEL_ID", "VEHICLE_TYPE_ID", "COUNTRY_ID", "PURPOSE_ID", "SPECIAL_ID", "ECO_CLASS_ID", "STEERING_TYPE_ID", "BUILD_YEAR", "BUILD_MONTH", "MAX_LOAD", "PAR_TYPE_ID", "OWNER_ID", "ARCHIVE_NO", "FIRST_ARCHIVE_NO", "PAGE_COUNT", "DESCRIPTION", "STATUS", "CREATED_BY", "CREATED_DATE", "UPDATED_BY", "UPDATED_DATE", "IS_STOLEN", "IS_WARNING", "INSERT_ARCHIVE_NO", "COLOR_NAME", "MARK_NAME", "MODEL_NAME", "VEHICLE_TYPE_NAME", "COUNTRY_NAME", "PURPOSE_NAME", "SPECIAL_NAME", "ECO_CLASS_NAME", "STEERING_TYPE_NAME", "PAR_TYPE_NAME", "WHEEL_NAME", "CLASS_NAME", "CLASSIFICATION_ID", "WHEEL_ID", "FUEL_TYPE_ID", "AXLE_COUNT", "TOTAL_WEIGHT", "SEAT_COUNT", "DOOR_COUNT", "OWN_WEIGHT", "HEIGHT", "WIDTH", "LENGTH", "MODIFICACE_NAME", "IS_HYBRID", "FUEL_PARENT_TYPE_ID", "FUEL_NAME", "ENGINE_MODEL_ID", "ENGINE_MODEL_NAME", "ENGINE_CAPACITY", "PAR_MARKER_ID", "PURPOSE_BASE_ID", "FIRST_NAME", "FAMILY_NAME", "OWNER_TYPE_NAME", "STATUS_NAME", "OWNER_COUNTRY_NAME", "LAST_NAME", "REGISTER_NO", "ADDRESS_DETAIL", "PHONE_NO", "OWNER_COUNTRY", "OWNER_TYPE_ID", "OWNER_PROVINCE_ID", "OWNER_DISTRICT_ID", "OWNER_DEVISION_UNIT_ID", "OWNER_MICRO_DISTRICT_ID", "OWNER_STREET", "OWNER_APARTMENT_NO", "OWNER_DOOR_NO", "OWNER_GENDER", "OWNER_HOMEPHONE", "OWNER_WORKPHONE", "OWNER_CELLPHONE", "START_DATE") AS 
  SELECT
    veh."ID",
    RVEH.ID VEHICLE_ID,
    veh."PLATE_NO",
    RVEH."CABIN_NO",
    VEH."IS_ENABLED",
    VEH."IS_PENDING",
    MM."VIN_NO",
    RVEH."ENGINE_NO",
    RVEH."COLOR_ID",
    VEH."CERTIFICATE_NO",
    RVEH."IMPORT_DATE",
    RVEH."DECLARATION_NO",
    MO."MARK_ID",
    RVEH."MODEL_ID",
    MM."VEHICLE_TYPE_ID",
    MA."COUNTRY_ID",
    pu."ID" PURPOSE_ID,
    RVEH."SPECIAL_ID",
    REM."ECO_CLASS_ID",
    RVEH."STEERING_TYPE_ID",
    VEH."BUILD_YEAR",
    VEH."BUILD_MONTH",
    MM."MAX_LOAD",
    RVEH."PAR_TYPE_ID",
    VEH."OWNER_ID",
    VEH."ARCHIVE_NO",
    VEH."FIRST_ARCHIVE_NO",
    VEH."PAGE_COUNT",
    VEH."DESCRIPTION",
    veh."STATUS",
    VEH."CREATED_BY",
    VEH."CREATED_DATE",
    VEH."UPDATED_BY",
    VEH."UPDATED_DATE",
    VEH.IS_STOLEN,
    VEH."IS_WARNING",
    VEH.INSERT_ARCHIVE_NO,
    co.name color_name,
    ma.name mark_name,
    mo.name model_name,
    vt.name vehicle_type_name,
    cy.name country_name,
    pu.name purpose_name,
    sp.name special_name,
    ec.name eco_class_name,
    st.name steering_type_name,
    pa.name par_type_name,
    wh.name wheel_name,
    cl.name class_name,
    mm."CLASSIFICATION_ID",
    RVEH."WHEEL_ID",
    --mo."CROP_TYPE_ID",
    ft."ID" FUEL_TYPE_ID,
    mm."AXLE_COUNT",
    mm."TOTAL_WEIGHT",
    mm."SEAT_COUNT",
    mm."DOOR_COUNT",
    mm."OWN_WEIGHT",
    mm."HEIGHT",
    mm."WIDTH",
    mm."LENGTH",
    mm."MODIFICACE_NAME",
    mm."IS_HYBRID",
    FT.parent_id FUEL_PARENT_TYPE_ID,
    FT.name fuel_name,
    RVEH.ENGINE_MODEL_ID,
    rem.NAME ENGINE_MODEL_NAME,
    --mm.ENGINE_CAPACITY,
    rem.ENGINE_CAPACITY,
    RVEH.PAR_MARKER_ID,
    PU.PURPOSE_BASE_ID,
    OW.FIRST_NAME,
     OW.FAMILY_NAME,
    OWT.NAME OWNER_TYPE_NAME,
    STA.NAME STATUS_NAME,
    OCY.NAME OWNER_COUNTRY_NAME,
    OW.LAST_NAME,
    OW.REGISTER_NO,
    OW.ADDRESS_DETAIL,
    OW.CELLPHONE || 
    CASE WHEN OW.HOMEPHONE IS NOT NULL THEN ',' || OW.HOMEPHONE ELSE '' END || 
    CASE WHEN OW.WORKPHONE IS NOT NULL THEN ',' || OW.WORKPHONE ELSE '' END 
    PHONE_NO,
    OW."COUNTRY_ID" OWNER_COUNTRY,
    OW."TYPE_ID" OWNER_TYPE_ID,
    NULL OWNER_PROVINCE_ID,
    NULL OWNER_DISTRICT_ID,
    OW."DEVISION_UNIT_ID" OWNER_DEVISION_UNIT_ID,
    NULL OWNER_MICRO_DISTRICT_ID,
    NULL OWNER_STREET,
    NULL OWNER_APARTMENT_NO,
    NULL OWNER_DOOR_NO,
    OW."GENDER" OWNER_GENDER,
    OW."HOMEPHONE" OWNER_HOMEPHONE,
    OW."WORKPHONE" OWNER_WORKPHONE,
    OW."CELLPHONE" OWNER_CELLPHONE,
    ROWSH.START_DATE
    --RL."TYPE_ID" LIMIT_TYPE_ID,
    --RVO."START_DATE" OWNER_START_DATE
FROM
    VRS.reg_vehicle_archive veh
LEFT JOIN VRS.REG_VEHICLE RVEH ON VEH.VEHICLE_ID=RVEH.ID
LEFT JOIN VRS.REF_COLOR CO ON RVEH.COLOR_ID=CO.ID
LEFT JOIN VRS.REG_MODIPICACE MM ON RVEH.MODEL_ID=MM.ID
LEFT JOIN VRS.REG_MODEL MO ON MM.MODEL_ID=MO.ID
LEFT JOIN VRS.REG_MARK MA ON MO.MARK_ID=MA.ID
LEFT JOIN VRS.REG_VEHICLE_TYPE VT ON MM.VEHICLE_TYPE_ID=VT.ID
LEFT JOIN VRS.REF_COUNTRY CY ON MA.COUNTRY_ID=CY.ID
LEFT JOIN VRS.REF_PURPOSE PU ON VT.PURPOSE_ID=PU.ID
LEFT JOIN VRS.REF_GENERAL SP ON RVEH.SPECIAL_ID=SP.ID
LEFT JOIN VRS.REF_GENERAL ST ON RVEH.STEERING_TYPE_ID=ST.ID
LEFT JOIN VRS.REF_GENERAL PA ON RVEH.PAR_TYPE_ID=PA.ID
--LEFT JOIN VRS.REF_GENERAL CR ON MO.CROP_TYPE_ID=CR.ID
LEFT JOIN VRS.REF_GENERAL WH ON RVEH.WHEEL_ID=WH.ID
LEFT JOIN VRS.REF_ENGINE_MODEL REM ON RVEH.ENGINE_MODEL_ID=REM.ID
LEFT JOIN VRS.REF_GENERAL EC ON REM.ECO_CLASS_ID=EC.ID
LEFT JOIN VRS.REF_GENERAL FT ON REM.FUEL_TYPE_ID=FT.ID
LEFT JOIN VRS.REF_GENERAL CL ON mm.CLASSIFICATION_ID=CL.ID
LEFT JOIN VRS.OWNER OW ON RVEH.OWNER_ID=OW.ID
LEFT JOIN VRS.REG_VEHICLE_OWNERSHIP ROWSH ON VEH.OWNER_ID=ROWSH.OWNER_ID AND RVEH.ID=ROWSH.VEHICLE_ID
LEFT JOIN VRS.OWNER_TYPE OWT ON OW.TYPE_ID=OWT.ID
LEFT JOIN VRS.REF_COUNTRY OCY ON VEH.COUNTRY_ID=OCY.ID
LEFT JOIN VRS.REG_STATUS STA ON VEH.STATUS=STA.ID
--LEFT JOIN VRS.REG_LIMITED RL ON veh.ID=RL.VEHICLE_ID
--LEFT JOIN VRS.REG_VEHICLE_OWNERSHIP RVO ON veh.ID=RVO.VEHICLE_ID
;
--------------------------------------------------------
--  DDL for View ARCHIVE_VIEW
--------------------------------------------------------

  CREATE OR REPLACE FORCE EDITIONABLE VIEW "VRS"."ARCHIVE_VIEW" ("ID", "VEHICLE_ID", "ARCHIVE_NO", "BUILD_YEAR", "ARCHIVE_DATE", "PLATE_NO", "PAGE_COUNT", "COUNTRY_ID", "CABIN_NO", "DECLARATION_NO", "MARK_NAME", "MODEL_NAME", "ENGINE_NO", "IMPORT_DATE", "CERTIFICATE_NO", "FIRST_NAME", "LAST_NAME", "USERNAME", "SERVICE_NAME", "SERVICE_ID", "VIN_NO", "UPDATED_DATE", "CREATED_BY", "FIRSTNAME", "PURPOSE_ID", "TYPE_ID", "DESCRIPTION", "INSERT_FINGER", "INSERT_FINGER_DESCRIPTION", "INSERT_DESCRIPTION") AS 
  SELECT
    ar.ID,
    ar."VEHICLE_ID",
    ar."ARCHIVE_NO",
    ar."BUILD_YEAR",
    CASE WHEN AR."CREATED_DATE" IS NULL THEN AR.INS_CREATED_DATE ELSE AR."CREATED_DATE" END "ARCHIVE_DATE",
    ar."PLATE_NO",
    ar."PAGE_COUNT",
    ar."COUNTRY_ID",
    ar."CABIN_NO",
    ar."DECLARATION_NO",
    RM."NAME" MARK_NAME,
    ar."MODEL_NAME",
    ar."ENGINE_NO",
    ar."IMPORT_DATE",
    ar."CERTIFICATE_NO",
    OW."FIRST_NAME",
    OW."LAST_NAME",
    US."USERNAME",
    --CASE WHEN ar.SERVICE_NAME IS NOT NULL THEN ar.SERVICE_NAME ELSE CHR(SS.NAME) END SERVICE_NAME,
    SS.NAME SERVICE_NAME,
    ar."SERVICE_ID",
    ar.VIN_NO,
    ar."UPDATED_DATE",
    ar.CREATED_BY,
    CASE WHEN US.FIRSTNAME IS NOT NULL THEN US.FIRSTNAME ELSE SU.BRANCH_NAME||'-'||SU.FULLNAME END FIRSTNAME,
    VT.PURPOSE_ID,
    OW.TYPE_ID,
    ar.DESCRIPTION,
    ar.INSERT_FINGER,
    ar.INSERT_FINGER_DESCRIPTION,
    ar.INSERT_DESCRIPTION
FROM
    VRS.REG_VEHICLE_ARCHIVE ar
LEFT JOIN VRS.REG_MARK RM ON ar.MARK_ID=RM.ID
LEFT JOIN VRS.OWNER OW ON ar.OWNER_ID=OW.ID
LEFT JOIN VRS.SYSTEM_USER US ON ar.CREATED_BY=US.ID
LEFT JOIN MVIS.SYS_USER_VIEW SU ON ar.INS_CREATED_BY=SU.ID
LEFT JOIN VRS.REG_VEHICLE VEH ON ar.VEHICLE_ID=VEH.ID
LEFT JOIN VRS.REG_MODIPICACE MM ON VEH.MODEL_ID=MM.ID
LEFT JOIN VRS.REG_MODEL MO ON MM.MODEL_ID=MO.ID
LEFT JOIN VRS.REG_VEHICLE_TYPE VT ON MM.VEHICLE_TYPE_ID=VT.ID
LEFT JOIN VRS.SYSTEM_SERVICE SS ON ar.SERVICE_ID=SS.ID
;
  GRANT SELECT ON "VRS"."ARCHIVE_VIEW" TO "MVIS";
--------------------------------------------------------
--  DDL for View ESIGN_VIEW
--------------------------------------------------------

  CREATE OR REPLACE FORCE EDITIONABLE VIEW "VRS"."ESIGN_VIEW" ("ID", "VEHICLE_ID", "SERVICE_CODE", "REQUEST_CODE", "PLATE_NO", "CABIN_NO", "MARK_NAME", "MODEL_NAME", "MODIFICACE_NAME", "VEHICLE_TYPE_NAME", "COLOR_NAME", "OWNER_ID", "OWNER_LASTNAME", "OWNER_FIRSTNAME", "OWNER_ADDRESS", "OWNER_REGNUM", "NEW_OWNER_ID", "NEW_OWNER_LASTNAME", "NEW_OWNER_FIRSTNAME", "NEW_OWNER_ADDRESS", "NEW_OWNER_REGNUM", "IS_BORROWING", "BORROWER_ID", "BORROWER_LASTNAME", "BORROWER_FIRSTNAME", "BORROWER_ADDRESS", "BORROWER_REGNUM", "NOTE", "IS_PAID", "IS_APPROVED", "CREATED_DATE", "IS_DELETED") AS 
  SELECT
    NULL id,
    NULL AS vehicle_id,
    NULL AS SERVICE_CODE,
    NULL AS REQUEST_CODE,
    NULL AS plate_no,
    NULL AS cabin_no,
    NULL AS MARK_NAME,
    NULL AS MODEL_NAME,
    NULL AS MODIFICACE_NAME,
    NULL AS VEHICLE_TYPE_NAME,
    NULL AS COLOR_NAME,
    NULL AS owner_id,
    NULL AS owner_lastname,
    NULL AS owner_firstname,
    NULL AS owner_address,
    NULL AS OWNER_REGNUM,
    NULL AS new_owner_id,
    NULL AS new_owner_lastname,
    NULL AS new_owner_firstname,
    NULL AS new_owner_address,
    NULL AS NEW_OWNER_REGNUM,
    NULL AS is_borrowing,
    NULL AS borrower_id,
    NULL AS borrower_lastname,
    NULL AS borrower_firstname,
    NULL AS borrower_address,
    NULL AS BORROWER_REGNUM,
    NULL NOTE,
    NULL AS IS_PAID,
    NULL AS IS_APPROVED,
    NULL AS CREATED_DATE,
    NULL AS is_deleted
FROM DUAL
;
  GRANT SELECT ON "VRS"."ESIGN_VIEW" TO "USER_INSP";
--------------------------------------------------------
--  DDL for View INSP_ARCHIVE_VIEW
--------------------------------------------------------

  CREATE OR REPLACE FORCE EDITIONABLE VIEW "VRS"."INSP_ARCHIVE_VIEW" ("ID", "VEHICLE_ID", "PLATE_NO", "CABIN_NO", "DECLARATION_NO", "BUILD_YEAR", "IMPORT_DATE", "PURPOSE_NAME", "WEIGHT", "BODY_SIZE", "ASD_COUNT", "COLOR_NAME", "ENGINE_MODEL_NAME", "BRANCH_NAME", "CREATED_NAME", "SPECIAL_NAME", "EXHAUST_NO", "CREATED_DATE", "NAME") AS 
  select 
    IA.ID, 
    IA.VEHICLE_ID,     
    IA.PLATE_NO,
    IA.CABIN_NO, 
    IA.DECLARATION_NO, 
    IA.BUILD_YEAR, 
    IA.IMPORT_DATE, 
    IA.PURPOSE_NAME,
    IA.WEIGHT, 
    IA.BODY_SIZE, 
    IA.ASD_COUNT, 
    IA.COLOR_NAME, 
    IA.ENGINE_MODEL_NAME, 
    IA.BRANCH_NAME, 
    IA.CREATED_NAME,
    IA.SPECIAL_NAME,
    IA.EXHAUST_NO,
    TO_CHAR(IA.CREATED_DATE,'YYYY-MM-DD HH24:MI') CREATED_DATE,
    SS.NAME
from VRS.reg_vehicle_insp_archive IA
LEFT JOIN vrs.system_service ss ON IA.service_id=ss.id
;
  GRANT SELECT ON "VRS"."INSP_ARCHIVE_VIEW" TO "MVIS";
--------------------------------------------------------
--  DDL for View MAIN_USER_VIEW
--------------------------------------------------------

  CREATE OR REPLACE FORCE EDITIONABLE VIEW "VRS"."MAIN_USER_VIEW" ("ID", "FIRSTNAME", "LASTNAME", "USERNAME", "USERPOSITIONID", "PROVINCEID", "DELETED_AT", "NAME", "DEPARTMENT", "POSITION", "ISACTIVE", "ISATVT", "ISCITY", "SESSION_ID") AS 
  SELECT
    MU."ID",
    MU."FIRSTNAME",
    MU."LASTNAME",
    MU."USERNAME",
    MU."USERPOSITIONID",
    MU."PROVINCEID",
	MU."DELETED_AT",
    AP."NAME",
	MD."NAME" DEPARTMENT,
	MP."NAME" POSITION,
    MU."ISACTIVE",
    MU."ISATVT",
    MU."ISCITY",
    MU."SESSION_ID"
FROM
    VRS.SYSTEM_USER MU
LEFT JOIN VRS.ADDRESS_PROVINCE_OLD AP ON MU.PROVINCEID=AP.ID
LEFT JOIN VRS.SYSTEM_POSITION MP ON MU.USERPOSITIONID=MP.ID
LEFT JOIN VRS.SYSTEM_DEPARTMENT MD ON MU.USERDEPARTMENTID=MD.ID
ORDER BY AP."NAME" ASC
;
--------------------------------------------------------
--  DDL for View OWNER_ANOTHER_VEHICLE_VIEW
--------------------------------------------------------

  CREATE OR REPLACE FORCE EDITIONABLE VIEW "VRS"."OWNER_ANOTHER_VEHICLE_VIEW" ("ID", "OWNER_ID", "PLATE_NO", "CABIN_NO", "ENGINE_NO", "BUILD_YEAR", "BUILD_MONTH", "COLOR_NAME", "MARK_NAME", "MODEL_NAME", "PAR_TYPE_NAME", "ENGINE_CAPACITY", "ENGINE_MODEL_ID", "ENGINE_MODEL_NAME", "START_DATE") AS 
  SELECT
    veh."ID",
    veh."OWNER_ID",
    veh."PLATE_NO",
    veh."CABIN_NO",
    veh."ENGINE_NO",
    veh."BUILD_YEAR",
    veh."BUILD_MONTH",
    co.name color_name,
    ma.name mark_name,
    mo.name model_name,
    pa.name par_type_name,
    REM."ENGINE_CAPACITY",
    veh.ENGINE_MODEL_ID,
    rem.NAME ENGINE_MODEL_NAME,
    veh.UPDATED_DATE START_DATE
FROM
    VRS.reg_vehicle veh
LEFT JOIN VRS.REF_COLOR CO ON VEH.COLOR_ID=CO.ID
LEFT JOIN VRS.REG_MODIPICACE MM ON VEH.MODEL_ID=MM.ID
LEFT JOIN VRS.REG_MODEL MO ON MM.MODEL_ID=MO.ID
LEFT JOIN VRS.REG_MARK MA ON MO.MARK_ID=MA.ID
LEFT JOIN VRS.REF_GENERAL PA ON VEH.PAR_TYPE_ID=PA.ID
LEFT JOIN VRS.REF_ENGINE_MODEL REM ON VEH.ENGINE_MODEL_ID=REM.ID
;
--------------------------------------------------------
--  DDL for View PLATESAVEVIEW
--------------------------------------------------------

  CREATE OR REPLACE FORCE EDITIONABLE VIEW "VRS"."PLATESAVEVIEW" ("ID", "VEHICLE_ID", "OWNER_ID", "ARCHIVE_NUMBER", "IS_DELETE", "IS_ACTIVE", "PLATE_NO", "CUSTOMER_REGNUM", "CUSTOMER_LASTNAME", "CUSTOMER_FIRSTNAME", "CUSTOMER_PHONE", "BEGIN_DATE", "END_DATE", "UPDATED_BY", "UPDATE_DATE", "DELETED_BY", "DELETE_DATE", "CREATED_BY", "CREATE_DATE", "SMS_UID", "SMS_STATUS", "SMS_SEND_DATE", "EXTEND_COUNT", "LASTNAME", "FIRSTNAME") AS 
  select ps."ID",ps."VEHICLE_ID",ps."OWNER_ID",ps."ARCHIVE_NUMBER",ps."IS_DELETE",ps."IS_ACTIVE",ps."PLATE_NO",ps."CUSTOMER_REGNUM",ps."CUSTOMER_LASTNAME",ps."CUSTOMER_FIRSTNAME",ps."CUSTOMER_PHONE",ps."BEGIN_DATE",ps."END_DATE",ps."UPDATED_BY",ps."UPDATE_DATE",ps."DELETED_BY",ps."DELETE_DATE",ps."CREATED_BY",ps."CREATE_DATE",ps."SMS_UID",ps."SMS_STATUS",ps."SMS_SEND_DATE",ps."EXTEND_COUNT",u.LASTNAME,u.FIRSTNAME from REG_PLATENUMBER_SAVE ps join SYSTEM_USER u on ps.created_by = u.ID where ps.is_active=1 order by  ps.CREATE_DATE desc
;
--------------------------------------------------------
--  DDL for View REF_COLOR_VIEW
--------------------------------------------------------

  CREATE OR REPLACE FORCE EDITIONABLE VIEW "VRS"."REF_COLOR_VIEW" ("ID", "NAME", "TYPE_ID", "TYPE_NAME", "STATUS") AS 
  SELECT CC."ID",CC."NAME",CC."TYPE_ID",CT.NAME TYPE_NAME, CC.STATUS
FROM VRS.REF_COLOR CC
INNER JOIN VRS.REF_COLOR_TYPE CT ON CC.TYPE_ID=CT.ID
;
  GRANT UPDATE ON "VRS"."REF_COLOR_VIEW" TO "MVIS";
  GRANT INSERT ON "VRS"."REF_COLOR_VIEW" TO "MVIS";
  GRANT DELETE ON "VRS"."REF_COLOR_VIEW" TO "MVIS";
  GRANT SELECT ON "VRS"."REF_COLOR_VIEW" TO "MVIS";
  GRANT MERGE VIEW ON "VRS"."REF_COLOR_VIEW" TO "USER_INSP";
  GRANT FLASHBACK ON "VRS"."REF_COLOR_VIEW" TO "USER_INSP";
  GRANT DEBUG ON "VRS"."REF_COLOR_VIEW" TO "USER_INSP";
  GRANT QUERY REWRITE ON "VRS"."REF_COLOR_VIEW" TO "USER_INSP";
  GRANT ON COMMIT REFRESH ON "VRS"."REF_COLOR_VIEW" TO "USER_INSP";
  GRANT REFERENCES ON "VRS"."REF_COLOR_VIEW" TO "USER_INSP";
  GRANT UPDATE ON "VRS"."REF_COLOR_VIEW" TO "USER_INSP";
  GRANT SELECT ON "VRS"."REF_COLOR_VIEW" TO "USER_INSP";
  GRANT INSERT ON "VRS"."REF_COLOR_VIEW" TO "USER_INSP";
  GRANT DELETE ON "VRS"."REF_COLOR_VIEW" TO "USER_INSP";
--------------------------------------------------------
--  DDL for View REF_ENGINE_MODEL_VIEW
--------------------------------------------------------

  CREATE OR REPLACE FORCE EDITIONABLE VIEW "VRS"."REF_ENGINE_MODEL_VIEW" ("ID", "NAME", "FUEL_TYPE_ID", "ECO_CLASS_ID", "STATUS", "FUEL_TYPE_NAME", "ECO_CLASS_NAME", "ENGINE_CAPACITY", "ENGINE_POWER", "MARK_ID", "MARK_NAME", "OCTANE_NUM_ID", "OCTANE_NAME", "IS_OTHER_MARK", "IS_TURBO", "CREATED_DATE", "CREATED_NAME", "UPDATED_DATE", "UPDATED_NAME") AS 
  SELECT 
    EM."ID",EM."NAME",EM."FUEL_TYPE_ID",EM."ECO_CLASS_ID",EM."STATUS", 
    FT.NAME FUEL_TYPE_NAME,
    EC.NAME ECO_CLASS_NAME,
    EM.ENGINE_CAPACITY,
    EM.ENGINE_POWER,
    MA.ID AS MARK_ID,
    MA.NAME AS MARK_NAME,
    OC.ID OCTANE_NUM_ID,
    OC.NAME OCTANE_NAME,
    EM."IS_OTHER_MARK",
    EM.IS_TURBO,
    TO_CHAR(EM.CREATED_DATE, 'YYYY-MM-DD HH24:MI') CREATED_DATE,
    CSU.FULLNAME CREATED_NAME,
    TO_CHAR(EM.UPDATED_DATE, 'YYYY-MM-DD HH24:MI') UPDATED_DATE,
    USU.FULLNAME UPDATED_NAME
FROM VRS.REF_ENGINE_MODEL EM
LEFT JOIN VRS.REF_GENERAL FT ON EM.FUEL_TYPE_ID=FT.ID
LEFT JOIN VRS.REF_GENERAL EC ON EM.ECO_CLASS_ID=EC.ID
LEFT JOIN VRS.REF_GENERAL OC ON EM.OCTANE_NUM_ID=OC.ID
LEFT JOIN VRS.REG_MARK MA ON EM.MARK_ID=MA.ID
LEFT JOIN MVIS.SYS_USER CSU ON EM.CREATED_BY=CSU.ID
LEFT JOIN MVIS.SYS_USER USU ON EM.UPDATED_BY=USU.ID
;
  GRANT UPDATE ON "VRS"."REF_ENGINE_MODEL_VIEW" TO "MVIS";
  GRANT INSERT ON "VRS"."REF_ENGINE_MODEL_VIEW" TO "MVIS";
  GRANT DELETE ON "VRS"."REF_ENGINE_MODEL_VIEW" TO "MVIS";
  GRANT SELECT ON "VRS"."REF_ENGINE_MODEL_VIEW" TO "MVIS";
  GRANT MERGE VIEW ON "VRS"."REF_ENGINE_MODEL_VIEW" TO "USER_INSP";
  GRANT FLASHBACK ON "VRS"."REF_ENGINE_MODEL_VIEW" TO "USER_INSP";
  GRANT DEBUG ON "VRS"."REF_ENGINE_MODEL_VIEW" TO "USER_INSP";
  GRANT QUERY REWRITE ON "VRS"."REF_ENGINE_MODEL_VIEW" TO "USER_INSP";
  GRANT ON COMMIT REFRESH ON "VRS"."REF_ENGINE_MODEL_VIEW" TO "USER_INSP";
  GRANT REFERENCES ON "VRS"."REF_ENGINE_MODEL_VIEW" TO "USER_INSP";
  GRANT UPDATE ON "VRS"."REF_ENGINE_MODEL_VIEW" TO "USER_INSP";
  GRANT SELECT ON "VRS"."REF_ENGINE_MODEL_VIEW" TO "USER_INSP";
  GRANT INSERT ON "VRS"."REF_ENGINE_MODEL_VIEW" TO "USER_INSP";
  GRANT DELETE ON "VRS"."REF_ENGINE_MODEL_VIEW" TO "USER_INSP";
--------------------------------------------------------
--  DDL for View REF_PURPOSE_VIEW
--------------------------------------------------------

  CREATE OR REPLACE FORCE EDITIONABLE VIEW "VRS"."REF_PURPOSE_VIEW" ("ID", "NAME", "IS_VIN", "PURPOSE_BASE_ID", "OLD_ID", "TOTAL_AMOUNT", "VAT_AMOUNT") AS 
  SELECT RP."ID",RP."NAME",RP."IS_VIN",RP."PURPOSE_BASE_ID",RP."OLD_ID",RPB.TOTAL_AMOUNT,rpb.vat_amount FROM VRS.REF_PURPOSE RP
INNER JOIN MVIS.REF_PURPOSE_BASE RPB ON rp.purpose_base_id=RPB.ID
 
;
  GRANT SELECT ON "VRS"."REF_PURPOSE_VIEW" TO "MVIS";
  GRANT MERGE VIEW ON "VRS"."REF_PURPOSE_VIEW" TO "USER_INSP";
  GRANT FLASHBACK ON "VRS"."REF_PURPOSE_VIEW" TO "USER_INSP";
  GRANT DEBUG ON "VRS"."REF_PURPOSE_VIEW" TO "USER_INSP";
  GRANT QUERY REWRITE ON "VRS"."REF_PURPOSE_VIEW" TO "USER_INSP";
  GRANT ON COMMIT REFRESH ON "VRS"."REF_PURPOSE_VIEW" TO "USER_INSP";
  GRANT REFERENCES ON "VRS"."REF_PURPOSE_VIEW" TO "USER_INSP";
  GRANT UPDATE ON "VRS"."REF_PURPOSE_VIEW" TO "USER_INSP";
  GRANT SELECT ON "VRS"."REF_PURPOSE_VIEW" TO "USER_INSP";
  GRANT INSERT ON "VRS"."REF_PURPOSE_VIEW" TO "USER_INSP";
  GRANT DELETE ON "VRS"."REF_PURPOSE_VIEW" TO "USER_INSP";
--------------------------------------------------------
--  DDL for View REG_LIMITED_VIEW
--------------------------------------------------------

  CREATE OR REPLACE FORCE EDITIONABLE VIEW "VRS"."REG_LIMITED_VIEW" ("ID", "TYPE_ID", "DEC_DATE", "DEC_NO", "PHONE_NO", "CREATEDDATE", "MODIFIEDDATE", "CREATEDBY", "MODIFIEDBY", "RESTORE_TYPE_ID", "RESTORE_DEC_NO", "RESTORE_USER_ID", "END_DATE", "VEHICLE_ID", "IS_RESTORED", "TYPENAME", "RESTORETYPENAME", "CREATEDUSER", "RESTOREUSER") AS 
  SELECT 
    RL."ID",
    RL."TYPE_ID",
    RL."DEC_DATE",
    RL."DEC_NO",
    RL."PHONE_NO",
    RL."CREATEDDATE",
    RL."MODIFIEDDATE",
    RL."CREATEDBY",
    RL."MODIFIEDBY",
    RL."RESTORE_TYPE_ID",
    RL."RESTORE_DEC_NO",
    RL."RESTORE_USER_ID",
    RL."END_DATE",
    RL."VEHICLE_ID",
    RL."IS_RESTORED",
    LT.NAME TYPENAME,
    LR.NAME RESTORETYPENAME,
    MU.FIRSTNAME CREATEDUSER,
    MR.FIRSTNAME RESTOREUSER
FROM REG_LIMITED RL
LEFT JOIN VRS.REG_LIMIT_TYPE LT ON RL.TYPE_ID=LT.ID
LEFT JOIN VRS.REG_LIMIT_TYPE LR ON RL.RESTORE_TYPE_ID=LR.ID
LEFT JOIN VRS.SYSTEM_USER MU ON RL.CREATEDBY=MU.ID
LEFT JOIN VRS.SYSTEM_USER MR ON RL.RESTORE_USER_ID=MR.ID
;
  GRANT SELECT ON "VRS"."REG_LIMITED_VIEW" TO "USER_NDC";
--------------------------------------------------------
--  DDL for View REG_MARK_VIEW
--------------------------------------------------------

  CREATE OR REPLACE FORCE EDITIONABLE VIEW "VRS"."REG_MARK_VIEW" ("ID", "NAME", "COUNTRY_ID", "STATUS", "CREATED_DATE", "CREATED_NAME", "UPDATED_DATE", "UPDATED_NAME", "OLD_ID", "COUNTRY_NAME") AS 
  SELECT 
    MM."ID",
    MM."NAME",
    MM."COUNTRY_ID",
    MM."STATUS",
    TO_CHAR(MM.CREATED_DATE, 'YYYY-MM-DD HH24:MI') CREATED_DATE,
    CSU.FULLNAME CREATED_NAME,
    TO_CHAR(MM.UPDATED_DATE, 'YYYY-MM-DD HH24:MI') UPDATED_DATE,
    USU.FULLNAME UPDATED_NAME,
    MM."OLD_ID",
    MT.NAME COUNTRY_NAME 
FROM VRS.REG_MARK MM
    INNER JOIN VRS.REF_COUNTRY MT ON MM.COUNTRY_ID=MT.ID
    LEFT JOIN MVIS.SYS_USER CSU ON MM.CREATED_BY=CSU.ID
    LEFT JOIN MVIS.SYS_USER USU ON MM.UPDATED_BY=USU.ID
;
  GRANT UPDATE ON "VRS"."REG_MARK_VIEW" TO "MVIS";
  GRANT INSERT ON "VRS"."REG_MARK_VIEW" TO "MVIS";
  GRANT DELETE ON "VRS"."REG_MARK_VIEW" TO "MVIS";
  GRANT SELECT ON "VRS"."REG_MARK_VIEW" TO "MVIS";
  GRANT MERGE VIEW ON "VRS"."REG_MARK_VIEW" TO "USER_INSP";
  GRANT FLASHBACK ON "VRS"."REG_MARK_VIEW" TO "USER_INSP";
  GRANT DEBUG ON "VRS"."REG_MARK_VIEW" TO "USER_INSP";
  GRANT QUERY REWRITE ON "VRS"."REG_MARK_VIEW" TO "USER_INSP";
  GRANT ON COMMIT REFRESH ON "VRS"."REG_MARK_VIEW" TO "USER_INSP";
  GRANT REFERENCES ON "VRS"."REG_MARK_VIEW" TO "USER_INSP";
  GRANT UPDATE ON "VRS"."REG_MARK_VIEW" TO "USER_INSP";
  GRANT SELECT ON "VRS"."REG_MARK_VIEW" TO "USER_INSP";
  GRANT INSERT ON "VRS"."REG_MARK_VIEW" TO "USER_INSP";
  GRANT DELETE ON "VRS"."REG_MARK_VIEW" TO "USER_INSP";
--------------------------------------------------------
--  DDL for View REG_MODEL_VIEW
--------------------------------------------------------

  CREATE OR REPLACE FORCE EDITIONABLE VIEW "VRS"."REG_MODEL_VIEW" ("ID", "NAME", "MARK_ID", "STATUS", "CREATED_DATE", "CREATED_NAME", "UPDATED_DATE", "UPDATED_NAME", "MARK_NAME", "COUNTRY_ID", "COUNTRY_NAME") AS 
  SELECT 
    MM."ID",
    MM."NAME",
    MM."MARK_ID",
    MM."STATUS",
    TO_CHAR(MM.CREATED_DATE, 'YYYY-MM-DD HH24:MI') CREATED_DATE,
    CSU.FULLNAME CREATED_NAME,
    TO_CHAR(MM.UPDATED_DATE, 'YYYY-MM-DD HH24:MI') UPDATED_DATE,
    USU.FULLNAME UPDATED_NAME,
    MA.NAME MARK_NAME,
    MA.COUNTRY_ID,
    CO.NAME COUNTRY_NAME 
FROM VRS.REG_MODEL MM
    LEFT JOIN VRS.REG_MARK MA ON MM.MARK_ID=MA.ID
    LEFT JOIN VRS.REF_COUNTRY CO ON MA.COUNTRY_ID=CO.ID
    LEFT JOIN MVIS.SYS_USER CSU ON MM.CREATED_BY=CSU.ID
    LEFT JOIN MVIS.SYS_USER USU ON MM.UPDATED_BY=USU.ID
;
  GRANT MERGE VIEW ON "VRS"."REG_MODEL_VIEW" TO "MVIS" WITH GRANT OPTION;
  GRANT FLASHBACK ON "VRS"."REG_MODEL_VIEW" TO "MVIS" WITH GRANT OPTION;
  GRANT DEBUG ON "VRS"."REG_MODEL_VIEW" TO "MVIS" WITH GRANT OPTION;
  GRANT QUERY REWRITE ON "VRS"."REG_MODEL_VIEW" TO "MVIS" WITH GRANT OPTION;
  GRANT ON COMMIT REFRESH ON "VRS"."REG_MODEL_VIEW" TO "MVIS" WITH GRANT OPTION;
  GRANT REFERENCES ON "VRS"."REG_MODEL_VIEW" TO "MVIS" WITH GRANT OPTION;
  GRANT UPDATE ON "VRS"."REG_MODEL_VIEW" TO "MVIS" WITH GRANT OPTION;
  GRANT INSERT ON "VRS"."REG_MODEL_VIEW" TO "MVIS" WITH GRANT OPTION;
  GRANT DELETE ON "VRS"."REG_MODEL_VIEW" TO "MVIS" WITH GRANT OPTION;
  GRANT SELECT ON "VRS"."REG_MODEL_VIEW" TO "MVIS" WITH GRANT OPTION;
  GRANT MERGE VIEW ON "VRS"."REG_MODEL_VIEW" TO "USER_INSP";
  GRANT FLASHBACK ON "VRS"."REG_MODEL_VIEW" TO "USER_INSP";
  GRANT DEBUG ON "VRS"."REG_MODEL_VIEW" TO "USER_INSP";
  GRANT QUERY REWRITE ON "VRS"."REG_MODEL_VIEW" TO "USER_INSP";
  GRANT ON COMMIT REFRESH ON "VRS"."REG_MODEL_VIEW" TO "USER_INSP";
  GRANT REFERENCES ON "VRS"."REG_MODEL_VIEW" TO "USER_INSP";
  GRANT UPDATE ON "VRS"."REG_MODEL_VIEW" TO "USER_INSP";
  GRANT SELECT ON "VRS"."REG_MODEL_VIEW" TO "USER_INSP";
  GRANT INSERT ON "VRS"."REG_MODEL_VIEW" TO "USER_INSP";
  GRANT DELETE ON "VRS"."REG_MODEL_VIEW" TO "USER_INSP";
--------------------------------------------------------
--  DDL for View REG_MODIPICACE_VIEW
--------------------------------------------------------

  CREATE OR REPLACE FORCE EDITIONABLE VIEW "VRS"."REG_MODIPICACE_VIEW" ("ID", "NAME", "VIN_NO", "MODEL_ID", "VEHICLE_TYPE_ID", "CLASSIFICATION_ID", "AXLE_COUNT", "TOTAL_WEIGHT", "SEAT_COUNT", "DOOR_COUNT", "MAX_LOAD", "OWN_WEIGHT", "HEIGHT", "WIDTH", "LENGTH", "MODIFICACE_NAME", "STATUS", "IS_HYBRID", "MARK_ID", "MARK_NAME", "MODEL_NAME", "VEHICLE_TYPE_NAME", "CLASS_NAME", "COUNTRY_ID", "COUNTRY_NAME", "PURPOSE_ID", "PURPOSE_NAME", "EM_ID", "EM_NAME", "CAPACITY", "IS_OTHER_MARK", "EC_ID", "EC_NAME", "FT_ID", "FT_NAME", "FT_PARENT_ID", "CREATED_DATE", "CREATED_NAME", "UPDATED_DATE", "UPDATED_NAME") AS 
  SELECT MM.ID,
		MO.NAME,
		MM.VIN_NO,
		MM.MODEL_ID,
		MM.VEHICLE_TYPE_ID,
		MM.CLASSIFICATION_ID,
		MM.AXLE_COUNT,
		MM.TOTAL_WEIGHT,
		MM.SEAT_COUNT,
		MM.DOOR_COUNT,
		MM.MAX_LOAD,
		MM.OWN_WEIGHT,
		MM.HEIGHT,
		MM.WIDTH,
		MM.LENGTH,
		MM.MODIFICACE_NAME,
		MM.STATUS,
		MM.IS_HYBRID,
		MA.ID MARK_ID, 
		MA.NAME MARK_NAME, 
		MO.NAME MODEL_NAME,
		VT.NAME VEHICLE_TYPE_NAME, 
		CA.NAME CLASS_NAME, 
		MA.COUNTRY_ID, 
		CO.NAME COUNTRY_NAME, 
		VT.PURPOSE_ID,
		PU.NAME PURPOSE_NAME, 
		RM.ID EM_ID,
        RM.NAME EM_NAME, 
		(CASE 	WHEN RM.ENGINE_CAPACITY IS NOT NULL THEN RM.ENGINE_CAPACITY 
				WHEN (RM.ENGINE_CAPACITY IS NULL AND RM.ENGINE_POWER IS NOT NULL) THEN RM.ENGINE_POWER ELSE NULL END) CAPACITY,
        RM.IS_OTHER_MARK,
		EC.ID EC_ID,
		EC.NAME EC_NAME,
		FT.ID FT_ID,
		FT.NAME FT_NAME,
		FT.PARENT_ID FT_PARENT_ID,
        TO_CHAR(MM.CREATED_DATE, 'YYYY-MM-DD HH24:MI') CREATED_DATE,
        CSU.FULLNAME CREATED_NAME,
        TO_CHAR(MM.UPDATED_DATE, 'YYYY-MM-DD HH24:MI') UPDATED_DATE,
        USU.FULLNAME UPDATED_NAME
FROM VRS.REG_MODIPICACE MM
		LEFT JOIN VRS.REG_MODEL MO ON MM.MODEL_ID=MO.ID
		LEFT JOIN VRS.REG_MARK MA ON MO.MARK_ID=MA.ID
		LEFT JOIN VRS.REF_COUNTRY CO ON MA.COUNTRY_ID=CO.ID
		LEFT JOIN VRS.REG_VEHICLE_TYPE VT ON MM.VEHICLE_TYPE_ID=VT.ID
		LEFT JOIN VRS.REF_PURPOSE PU ON VT.PURPOSE_ID=PU.ID
		LEFT JOIN VRS.REF_GENERAL CA ON MM.CLASSIFICATION_ID=CA.ID
		LEFT JOIN VRS.REF_ENGINE_MODEL RM ON MM.ENGINE_MODEL_ID=RM.ID
		LEFT JOIN VRS.REF_GENERAL EC ON RM.ECO_CLASS_ID=EC.ID
		LEFT JOIN VRS.REF_GENERAL FT ON RM.FUEL_TYPE_ID=FT.ID
        LEFT JOIN MVIS.SYS_USER CSU ON MM.CREATED_BY=CSU.ID
        LEFT JOIN MVIS.SYS_USER USU ON MM.UPDATED_BY=USU.ID
;
  GRANT MERGE VIEW ON "VRS"."REG_MODIPICACE_VIEW" TO "MVIS" WITH GRANT OPTION;
  GRANT FLASHBACK ON "VRS"."REG_MODIPICACE_VIEW" TO "MVIS" WITH GRANT OPTION;
  GRANT DEBUG ON "VRS"."REG_MODIPICACE_VIEW" TO "MVIS" WITH GRANT OPTION;
  GRANT QUERY REWRITE ON "VRS"."REG_MODIPICACE_VIEW" TO "MVIS" WITH GRANT OPTION;
  GRANT ON COMMIT REFRESH ON "VRS"."REG_MODIPICACE_VIEW" TO "MVIS" WITH GRANT OPTION;
  GRANT REFERENCES ON "VRS"."REG_MODIPICACE_VIEW" TO "MVIS" WITH GRANT OPTION;
  GRANT UPDATE ON "VRS"."REG_MODIPICACE_VIEW" TO "MVIS" WITH GRANT OPTION;
  GRANT INSERT ON "VRS"."REG_MODIPICACE_VIEW" TO "MVIS" WITH GRANT OPTION;
  GRANT DELETE ON "VRS"."REG_MODIPICACE_VIEW" TO "MVIS" WITH GRANT OPTION;
  GRANT SELECT ON "VRS"."REG_MODIPICACE_VIEW" TO "MVIS" WITH GRANT OPTION;
  GRANT MERGE VIEW ON "VRS"."REG_MODIPICACE_VIEW" TO "USER_INSP";
  GRANT FLASHBACK ON "VRS"."REG_MODIPICACE_VIEW" TO "USER_INSP";
  GRANT DEBUG ON "VRS"."REG_MODIPICACE_VIEW" TO "USER_INSP";
  GRANT QUERY REWRITE ON "VRS"."REG_MODIPICACE_VIEW" TO "USER_INSP";
  GRANT ON COMMIT REFRESH ON "VRS"."REG_MODIPICACE_VIEW" TO "USER_INSP";
  GRANT REFERENCES ON "VRS"."REG_MODIPICACE_VIEW" TO "USER_INSP";
  GRANT UPDATE ON "VRS"."REG_MODIPICACE_VIEW" TO "USER_INSP";
  GRANT SELECT ON "VRS"."REG_MODIPICACE_VIEW" TO "USER_INSP";
  GRANT INSERT ON "VRS"."REG_MODIPICACE_VIEW" TO "USER_INSP";
  GRANT DELETE ON "VRS"."REG_MODIPICACE_VIEW" TO "USER_INSP";
--------------------------------------------------------
--  DDL for View REG_OWNER_VIEW
--------------------------------------------------------

  CREATE OR REPLACE FORCE EDITIONABLE VIEW "VRS"."REG_OWNER_VIEW" ("ID", "NAME", "REGISTER_NO", "FAMILY_NAME", "LAST_NAME", "FIRST_NAME", "CREATE_DATE", "COUNTRY_ID", "COUNTRY", "PROVINCE_ID", "PROVINCE_NAME", "DISTRICT_ID", "DISTRICT_NAME", "DEVISION_UNIT_ID", "DEVISION_UNIT_NAME", "MICRO_DISTRICT_ID", "MICRO_DISTRICT_NAME", "ADDRESS", "CELLPHONE", "HOMEPHONE", "WORKPHONE", "PHONE_NO", "OWNER_TYPE_ID", "DOOR_NO", "APARTMENT_NO", "STREET", "GENDER", "STATUS_NAME") AS 
  SELECT 
    OW.ID, 
    OT.NAME,
    OW.REGISTER_NO,
    OW.FAMILY_NAME, 
    OW.LAST_NAME,
    OW.FIRST_NAME,
    OW.CREATE_DATE,
    OW.COUNTRY_ID,
    RC.NAME COUNTRY,
    NVL(PROVINCE.ID, PROVINCE_OLD.NEW_ID) AS PROVINCE_ID,
    NVL(PROVINCE.NAME, PROVINCE_OLD.NAME) AS PROVINCE_NAME,
    NVL(DISTRICT.ID, DISTRICT_OLD.ID) AS DISTRICT_ID,
    NVL(DISTRICT.NAME, DISTRICT_OLD.NAME) AS DISTRICT_NAME,
    NVL(SUBDEV.ID, SUBDEV_OLD.ID) AS DEVISION_UNIT_ID,
    NVL(SUBDEV.NAME, SUBDEV_OLD.NAME) AS DEVISION_UNIT_NAME,
    NULL MICRO_DISTRICT_ID,
    NULL MICRO_DISTRICT_NAME,
    ADDRESS_DETAIL ADDRESS, 
    OW.CELLPHONE,
    OW.HOMEPHONE,
    OW.WORKPHONE,
    OW.CELLPHONE || CASE WHEN OW.HOMEPHONE IS NOT NULL THEN ','||OW.HOMEPHONE ELSE '' END || CASE WHEN OW.WORKPHONE IS NOT NULL THEN ','||OW.WORKPHONE ELSE '' END PHONE_NO, 
    OT.ID OWNER_TYPE_ID,
    NULL DOOR_NO,
    NULL APARTMENT_NO,
    NULL STREET,
    OW.GENDER,
    OS.NAME STATUS_NAME
FROM VRS.OWNER OW
LEFT JOIN VRS.OWNER_TYPE OT ON OW.TYPE_ID=OT.ID
LEFT JOIN VRS.REF_COUNTRY RC ON OW.COUNTRY_ID=RC.ID
LEFT JOIN VRS.ADDRESS_PROVINCE_OLD PROVINCE_OLD ON OW.OLD_PROVINCE_ID=PROVINCE_OLD.ID
LEFT JOIN VRS.ADDRESS_SUBDEV_OLD DISTRICT_OLD ON OW.OLD_DISTRICT_ID=DISTRICT_OLD.ID
LEFT JOIN VRS.ADDRESS_SUBDEV_UNIT_OLD SUBDEV_OLD ON OW.OLD_DEVISION_UNIT_ID=SUBDEV_OLD.ID
-- LEFT JOIN VRS.ADDRESS_MICRODISTRICT AM ON OW.MICRO_DISTRICT_ID=AM.ID
LEFT JOIN VRS.ADDRESS_SUBDEV_UNIT SUBDEV ON OW.DEVISION_UNIT_ID=SUBDEV.ID
LEFT JOIN VRS.ADDRESS_SUBDEV DISTRICT ON SUBDEV.DEVISION_ID=DISTRICT.ID
LEFT JOIN VRS.ADDRESS_PROVINCE PROVINCE ON DISTRICT.PROVINCE_ID=PROVINCE.ID
LEFT JOIN VRS.OWNER_STATUS OS ON OW.STATUS=OS.ID
--WHERE OW.REGISTER_NO='ВБ84081911'
;
  GRANT SELECT ON "VRS"."REG_OWNER_VIEW" TO "USER_NDC";
  GRANT SELECT ON "VRS"."REG_OWNER_VIEW" TO "MVIS";
  GRANT SELECT ON "VRS"."REG_OWNER_VIEW" TO "USER_INSP";
  GRANT SELECT ON "VRS"."REG_OWNER_VIEW" TO "USER_EMONGOL";
--------------------------------------------------------
--  DDL for View REG_RFID_TAG_VIEW
--------------------------------------------------------

  CREATE OR REPLACE FORCE EDITIONABLE VIEW "VRS"."REG_RFID_TAG_VIEW" ("ID", "TID", "EPC", "CREATED_BRANCH", "CREATED_USER", "CREATED_DATE", "UPDATED_BRANCH", "UPDATED_USER", "UPDATED_DATE", "STATUS") AS 
  SELECT 
    RT.ID,
    RT.TID,
    RT.EPC,
    CU.BRANCH_NAME CREATED_BRANCH,
    CU.FULLNAME CREATED_USER,
    RT.CREATED_DATE,
    UU.BRANCH_NAME UPDATED_BRANCH,
    UU.FULLNAME UPDATED_USER,
    RT.UPDATED_DATE,
    RT.STATUS
FROM VRS.REG_RFID_TAG RT
LEFT JOIN MVIS.SYS_USER_VIEW CU ON RT.CREATED_BY=CU.ID
LEFT JOIN MVIS.SYS_USER_VIEW UU ON RT.CREATED_BY=UU.ID
;
  GRANT SELECT ON "VRS"."REG_RFID_TAG_VIEW" TO "MVIS";
--------------------------------------------------------
--  DDL for View REG_VEHICLE_INSP_VIEW
--------------------------------------------------------

  CREATE OR REPLACE FORCE EDITIONABLE VIEW "VRS"."REG_VEHICLE_INSP_VIEW" ("ID", "PLATE_NO", "CABIN_NO", "ENGINE_NO", "CERTIFICATE_NO", "DECLARATION_NO", "BUILD_YEAR", "BUILD_MONTH", "IMPORT_DATE", "DESCRIPTION", "IS_ENABLED", "IS_PENDING", "IS_STOLEN", "IS_WARNING", "STATUS", "CREATED_DATE", "INS_CREATED_DATE", "IMPORT_ODOMETER", "IMPORT_COUNTRY", "INS_CREATED_NAME", "EXHAUST_NO", "PURPOSE_ID", "PURPOSE_NAME", "PURPOSE_BASE_ID", "VEHICLE_TYPE_ID", "VEHICLE_TYPE_NAME", "COUNTRY_ID", "COUNTRY_NAME", "MARK_ID", "MARK_NAME", "MODEL_ORIG_ID", "MODEL_NAME", "MODEL_ID", "MODIFICACE_NAME", "VIN_NO", "AXLE_COUNT", "SEAT_COUNT", "DOOR_COUNT", "OWN_WEIGHT", "MAX_LOAD", "TOTAL_WEIGHT", "HEIGHT", "WIDTH", "LENGTH", "IS_HYBRID", "ENGINE_MODEL_ID", "ENGINE_MODEL_NAME", "CAPACITY", "WHEEL_ID", "WHEEL_NAME", "PAR_MARKER_ID", "PAR_TYPE_NAME", "COLOR_ID", "COLOR_NAME", "SPECIAL_ID", "SPECIAL_NAME", "STEERING_TYPE_ID", "STEERING_TYPE_NAME", "ECO_CLASS_ID", "ECO_NAME", "CLASS_ID", "CLASS_NAME", "FUEL_TYPE_ID", "FUEL_PARENT_TYPE_ID", "FUEL_NAME", "OWNER_ID", "FIRST_NAME", "LAST_NAME", "REGISTER_NO", "PROVINCE_ID", "PROVINCE_NAME", "DISTRICT_ID", "DISTRICT_NAME", "DEVISION_UNIT_ID", "DEVISION_UNIT_NAME", "ADDRESS", "OWNER1_ID", "IS_CERT_REVOKE") AS 
  SELECT
    VEH.ID,
    VEH.PLATE_NO,
    VEH.CABIN_NO,
    VEH.ENGINE_NO,
    VEH.CERTIFICATE_NO,
    VEH.DECLARATION_NO,
    VEH.BUILD_YEAR,
    VEH.BUILD_MONTH,
    VEH.IMPORT_DATE,
    VEH.DESCRIPTION,
    VEH.IS_ENABLED,
    VEH.IS_PENDING,
    VEH.IS_STOLEN,
    VEH.IS_WARNING,
    VEH.STATUS,
    VEH.CREATED_DATE,
    --VEH.UPDATED_DATE,
    VEH.INS_CREATED_DATE,
    VEH.IMPORT_ODOMETER,
    VEH.IMPORT_COUNTRY,
    SU.FULLNAME INS_CREATED_NAME,
    VEH.exhaust_no,
	PU.ID PURPOSE_ID,
	PU.NAME PURPOSE_NAME,
	PU.PURPOSE_BASE_ID,
	VT. ID VEHICLE_TYPE_ID, 
	VT.NAME VEHICLE_TYPE_NAME,
	CY.ID COUNTRY_ID,
	CY.NAME COUNTRY_NAME,
    MA.ID MARK_ID,
	MA.NAME MARK_NAME,
    MO.ID MODEL_ORIG_ID,
	MO.NAME MODEL_NAME,    
    MM.ID MODEL_ID,
	MM.MODIFICACE_NAME,
	MM.VIN_NO,
    MM.AXLE_COUNT,
    MM.SEAT_COUNT,
    MM.DOOR_COUNT,
    MM.OWN_WEIGHT,
    MM.MAX_LOAD,
    MM.TOTAL_WEIGHT,
    MM.HEIGHT,
    MM.WIDTH,
    MM.LENGTH,
    MM.IS_HYBRID,
    REM.ID ENGINE_MODEL_ID,
    REM.NAME ENGINE_MODEL_NAME,
    (CASE WHEN (REM.ENGINE_POWER IS NULL OR REM.ENGINE_POWER=0) THEN REM.ENGINE_CAPACITY ELSE REM.ENGINE_POWER END) CAPACITY,	
    WH.ID WHEEL_ID,
	WH.NAME WHEEL_NAME,
	PA.ID PAR_MARKER_ID,
	PA.NAME PAR_TYPE_NAME,
    CO.ID COLOR_ID,
	CO.NAME COLOR_NAME,
    SP.ID SPECIAL_ID,
	SP.NAME SPECIAL_NAME,
    ST.ID STEERING_TYPE_ID,
	ST.NAME STEERING_TYPE_NAME,
    EC.ID ECO_CLASS_ID,
	--EC.NAME ECO_CLASS_NAME,
    EC.NAME ECO_NAME,
    CL.ID CLASS_ID,
	CL.NAME CLASS_NAME,
    FT.ID FUEL_TYPE_ID,
    FT.PARENT_ID FUEL_PARENT_TYPE_ID,
    FT.NAME FUEL_NAME,
    VEH.OWNER_ID,
    OW.FIRST_NAME,  
    OW.LAST_NAME, 
    OW.REGISTER_NO,
    OW.PROVINCE_ID,
    OW.PROVINCE_NAME,
    OW.DISTRICT_ID,
    OW.DISTRICT_NAME, 
    OW.DEVISION_UNIT_ID,
    OW.DEVISION_UNIT_NAME, 
    (OW.PROVINCE_NAME||' ' || OW.DISTRICT_NAME||' '||OW.DEVISION_UNIT_NAME||' '||OW.MICRO_DISTRICT_NAME) ADDRESS,
    VEH.OWNER1_ID,
    VEH.IS_CERT_REVOKE
FROM
    VRS.REG_VEHICLE VEH
LEFT JOIN VRS.REF_COLOR CO ON VEH.COLOR_ID=CO.ID
LEFT JOIN VRS.REG_MODIPICACE MM ON VEH.MODEL_ID=MM.ID
LEFT JOIN VRS.REG_MODEL MO ON MM.MODEL_ID=MO.ID
LEFT JOIN VRS.REG_MARK MA ON MO.MARK_ID=MA.ID
LEFT JOIN VRS.REG_VEHICLE_TYPE VT ON MM.VEHICLE_TYPE_ID=VT.ID
LEFT JOIN VRS.REF_COUNTRY CY ON MA.COUNTRY_ID=CY.ID
LEFT JOIN VRS.REF_PURPOSE PU ON VT.PURPOSE_ID=PU.ID
LEFT JOIN VRS.REF_GENERAL SP ON VEH.SPECIAL_ID=SP.ID
LEFT JOIN VRS.REF_GENERAL ST ON VEH.STEERING_TYPE_ID=ST.ID
LEFT JOIN VRS.REF_GENERAL PA ON VEH.PAR_MARKER_ID=PA.ID
--LEFT JOIN VRS.REF_GENERAL CR ON MO.CROP_TYPE_ID=CR.ID
LEFT JOIN VRS.REF_GENERAL WH ON VEH.WHEEL_ID=WH.ID
LEFT JOIN VRS.REF_ENGINE_MODEL REM ON MM.ENGINE_MODEL_ID=REM.ID
LEFT JOIN VRS.REF_GENERAL EC ON REM.ECO_CLASS_ID=EC.ID
LEFT JOIN VRS.REF_GENERAL FT ON REM.FUEL_TYPE_ID=FT.ID
LEFT JOIN VRS.REF_GENERAL CL ON MM.CLASSIFICATION_ID=CL.ID
LEFT JOIN MVIS.SYS_USER SU ON VEH.INS_CREATED_BY=SU.ID
LEFT JOIN VRS.REG_OWNER_VIEW OW ON VEH.OWNER_ID=OW.ID
--WHERE VEh.PLATE_no='2112УНЧ'
;
  GRANT MERGE VIEW ON "VRS"."REG_VEHICLE_INSP_VIEW" TO "MVIS" WITH GRANT OPTION;
  GRANT FLASHBACK ON "VRS"."REG_VEHICLE_INSP_VIEW" TO "MVIS" WITH GRANT OPTION;
  GRANT DEBUG ON "VRS"."REG_VEHICLE_INSP_VIEW" TO "MVIS" WITH GRANT OPTION;
  GRANT QUERY REWRITE ON "VRS"."REG_VEHICLE_INSP_VIEW" TO "MVIS" WITH GRANT OPTION;
  GRANT ON COMMIT REFRESH ON "VRS"."REG_VEHICLE_INSP_VIEW" TO "MVIS" WITH GRANT OPTION;
  GRANT REFERENCES ON "VRS"."REG_VEHICLE_INSP_VIEW" TO "MVIS" WITH GRANT OPTION;
  GRANT INSERT ON "VRS"."REG_VEHICLE_INSP_VIEW" TO "MVIS" WITH GRANT OPTION;
  GRANT DELETE ON "VRS"."REG_VEHICLE_INSP_VIEW" TO "MVIS" WITH GRANT OPTION;
  GRANT UPDATE ON "VRS"."REG_VEHICLE_INSP_VIEW" TO "MVIS" WITH GRANT OPTION;
  GRANT SELECT ON "VRS"."REG_VEHICLE_INSP_VIEW" TO "USER_INSP";
  GRANT SELECT ON "VRS"."REG_VEHICLE_INSP_VIEW" TO "MVIS" WITH GRANT OPTION;
  GRANT SELECT ON "VRS"."REG_VEHICLE_INSP_VIEW" TO "USER_NDC";
--------------------------------------------------------
--  DDL for View REG_VEHICLE_OWNERSHIP1_VIEW
--------------------------------------------------------

  CREATE OR REPLACE FORCE EDITIONABLE VIEW "VRS"."REG_VEHICLE_OWNERSHIP1_VIEW" ("SHIP_ID", "REGISTER_NO", "FIRST_NAME", "FAMILY_NAME", "LAST_NAME", "PHONE_NO", "CELLPHONE", "HOMEPHONE", "WORKPHONE", "ADDRESS_DETAIL", "VEHICLE_ID", "START_DATE", "END_DATE") AS 
  SELECT
    rvo."ID" SHIP_ID,
    OW."REGISTER_NO",
    OW."FIRST_NAME",
    OW."FAMILY_NAME",
    OW."LAST_NAME",
    OW.CELLPHONE ||
    CASE WHEN OW.HOMEPHONE IS NOT NULL THEN ',' || OW.HOMEPHONE ELSE '' END ||
    CASE WHEN OW.WORKPHONE IS NOT NULL THEN ',' || OW.WORKPHONE ELSE '' END
    PHONE_NO,
    OW.CELLPHONE,
    OW.HOMEPHONE,
    OW.WORKPHONE,
    ADDRESS_DETAIL,
    rvo."VEHICLE_ID",
    rvo."START_DATE",
    rvo."END_DATE"
FROM
    VRS.reg_vehicle_owner1ship rvo
LEFT JOIN VRS.OWNER OW ON rvo.OWNER1_ID=OW.ID
;
--------------------------------------------------------
--  DDL for View REG_VEHICLE_OWNERSHIP_VIEW
--------------------------------------------------------

  CREATE OR REPLACE FORCE EDITIONABLE VIEW "VRS"."REG_VEHICLE_OWNERSHIP_VIEW" ("SHIP_ID", "REGISTER_NO", "FIRST_NAME", "FAMILY_NAME", "LAST_NAME", "PHONE_NO", "CELLPHONE", "HOMEPHONE", "WORKPHONE", "ADDRESS_DETAIL", "VEHICLE_ID", "START_DATE", "END_DATE") AS 
  SELECT
    rvo."ID" SHIP_ID,
    OW."REGISTER_NO",
    OW."FIRST_NAME",
    OW."FAMILY_NAME",
    OW."LAST_NAME",
    OW.CELLPHONE || 
    CASE WHEN OW.HOMEPHONE IS NOT NULL THEN ',' || OW.HOMEPHONE ELSE '' END || 
    CASE WHEN OW.WORKPHONE IS NOT NULL THEN ',' || OW.WORKPHONE ELSE '' END 
    PHONE_NO, 
    OW.CELLPHONE,
    OW.HOMEPHONE,
    OW.WORKPHONE,
    ADDRESS_DETAIL,
    rvo."VEHICLE_ID",
    rvo."START_DATE",
    rvo."END_DATE"
FROM
    VRS.reg_vehicle_ownership rvo
LEFT JOIN VRS.OWNER OW ON rvo.OWNER_ID=OW.ID
;
--------------------------------------------------------
--  DDL for View REG_VEHICLE_TYPE_VIEW
--------------------------------------------------------

  CREATE OR REPLACE FORCE EDITIONABLE VIEW "VRS"."REG_VEHICLE_TYPE_VIEW" ("ID", "NAME", "NAMEMON", "NAMEENG", "DESCRIPTION", "DECELERATION", "TREADDEPTH", "FREEOPERATION", "STATUS", "PURPOSE_ID", "PURPOSE_NAME", "PURPOSE_BASE_ID", "PURPOSE_BASE_NAME", "TOTAL_AMOUNT", "VAT_AMOUNT", "INSP_YEAR_COUNT", "CREATED_DATE", "CREATED_NAME", "UPDATED_DATE", "UPDATED_NAME") AS 
  SELECT 
    VT."ID",
    VT."NAME"||+ (CASE WHEN VT."NAMEENG" IS NOT NULL THEN (' - '||+VT."NAMEENG") ELSE NULL END) NAME,
    VT."NAME" NAMEMON,
    VT."NAMEENG",
    VT."DESCRIPTION",
    VT."DECELERATION",
    VT."TREADDEPTH",
    VT."FREEOPERATION",
    VT."STATUS",
    VT."PURPOSE_ID",
    PU.NAME PURPOSE_NAME,
    PB.ID PURPOSE_BASE_ID,
    PB.NAME PURPOSE_BASE_NAME,
    PB.TOTAL_AMOUNT,
    PB.VAT_AMOUNT,
    PB.INSP_YEAR_COUNT,
    TO_CHAR(VT.CREATED_DATE, 'YYYY-MM-DD HH24:MI') CREATED_DATE,
    CSU.FULLNAME CREATED_NAME,
    TO_CHAR(VT.UPDATED_DATE, 'YYYY-MM-DD HH24:MI') UPDATED_DATE,
    USU.FULLNAME UPDATED_NAME
FROM VRS.REG_VEHICLE_TYPE VT
    INNER JOIN VRS.REF_PURPOSE PU ON VT.PURPOSE_ID=PU.ID
    LEFT JOIN MVIS.REF_PURPOSE_BASE PB ON PU.PURPOSE_BASE_ID=PB.ID
    LEFT JOIN MVIS.SYS_USER CSU ON VT.CREATED_BY=CSU.ID
    LEFT JOIN MVIS.SYS_USER USU ON VT.UPDATED_BY=USU.ID
;
  GRANT MERGE VIEW ON "VRS"."REG_VEHICLE_TYPE_VIEW" TO "MVIS" WITH GRANT OPTION;
  GRANT FLASHBACK ON "VRS"."REG_VEHICLE_TYPE_VIEW" TO "MVIS" WITH GRANT OPTION;
  GRANT DEBUG ON "VRS"."REG_VEHICLE_TYPE_VIEW" TO "MVIS" WITH GRANT OPTION;
  GRANT QUERY REWRITE ON "VRS"."REG_VEHICLE_TYPE_VIEW" TO "MVIS" WITH GRANT OPTION;
  GRANT ON COMMIT REFRESH ON "VRS"."REG_VEHICLE_TYPE_VIEW" TO "MVIS" WITH GRANT OPTION;
  GRANT REFERENCES ON "VRS"."REG_VEHICLE_TYPE_VIEW" TO "MVIS" WITH GRANT OPTION;
  GRANT UPDATE ON "VRS"."REG_VEHICLE_TYPE_VIEW" TO "MVIS" WITH GRANT OPTION;
  GRANT INSERT ON "VRS"."REG_VEHICLE_TYPE_VIEW" TO "MVIS" WITH GRANT OPTION;
  GRANT DELETE ON "VRS"."REG_VEHICLE_TYPE_VIEW" TO "MVIS" WITH GRANT OPTION;
  GRANT SELECT ON "VRS"."REG_VEHICLE_TYPE_VIEW" TO "MVIS" WITH GRANT OPTION;
  GRANT MERGE VIEW ON "VRS"."REG_VEHICLE_TYPE_VIEW" TO "USER_INSP";
  GRANT FLASHBACK ON "VRS"."REG_VEHICLE_TYPE_VIEW" TO "USER_INSP";
  GRANT DEBUG ON "VRS"."REG_VEHICLE_TYPE_VIEW" TO "USER_INSP";
  GRANT QUERY REWRITE ON "VRS"."REG_VEHICLE_TYPE_VIEW" TO "USER_INSP";
  GRANT ON COMMIT REFRESH ON "VRS"."REG_VEHICLE_TYPE_VIEW" TO "USER_INSP";
  GRANT REFERENCES ON "VRS"."REG_VEHICLE_TYPE_VIEW" TO "USER_INSP";
  GRANT UPDATE ON "VRS"."REG_VEHICLE_TYPE_VIEW" TO "USER_INSP";
  GRANT SELECT ON "VRS"."REG_VEHICLE_TYPE_VIEW" TO "USER_INSP";
  GRANT INSERT ON "VRS"."REG_VEHICLE_TYPE_VIEW" TO "USER_INSP";
  GRANT DELETE ON "VRS"."REG_VEHICLE_TYPE_VIEW" TO "USER_INSP";
--------------------------------------------------------
--  DDL for View REG_VEHICLE_VIEW
--------------------------------------------------------

  CREATE OR REPLACE FORCE EDITIONABLE VIEW "VRS"."REG_VEHICLE_VIEW" ("ID", "PLATE_NO", "CABIN_NO", "ENGINE_NO", "DECLARATION_NO", "BUILD_YEAR", "BUILD_MONTH", "IMPORT_DATE", "CERTIFICATE_NO", "COLOR_ID", "COLOR_NAME", "PURPOSE_BASE_ID", "PURPOSE_ID", "PURPOSE_NAME", "VEHICLE_TYPE_ID", "VEHICLE_TYPE_NAME", "COUNTRY_ID", "COUNTRY_NAME", "MARK_ID", "MARK_NAME", "MODEL_ID", "MODEL_NAME", "VIN_NO", "MODIFICACE_NAME", "SPECIAL_ID", "SPECIAL_NAME", "STEERING_TYPE_ID", "STEERING_TYPE_NAME", "ENGINE_MODEL_ID", "ENGINE_MODEL_NAME", "ENGINE_CAPACITY", "FUEL_PARENT_TYPE_ID", "FUEL_TYPE_ID", "FUEL_NAME", "ECO_CLASS_ID", "ECO_CLASS_NAME", "PAR_MARKER_ID", "PAR_TYPE_NAME", "CLASSIFICATION_ID", "CLASS_NAME", "WHEEL_ID", "WHEEL_NAME", "AXLE_COUNT", "SEAT_COUNT", "DOOR_COUNT", "OWN_WEIGHT", "MAX_LOAD", "TOTAL_WEIGHT", "HEIGHT", "WIDTH", "LENGTH", "IS_HYBRID", "IS_ENABLED", "IS_PENDING", "ARCHIVE_NO", "FIRST_ARCHIVE_NO", "PAGE_COUNT", "DESCRIPTION", "CREATED_BY", "CREATED_DATE", "UPDATED_BY", "UPDATED_DATE", "IS_STOLEN", "IS_WARNING", "STATUS", "STATUS_NAME", "OWNER_ID", "OWNER_COUNTRY", "OWNER_COUNTRY_NAME", "OWNER_TYPE_ID", "OWNER_TYPE_NAME", "FAMILY_NAME", "LAST_NAME", "FIRST_NAME", "REGISTER_NO", "OWNER_PROVINCE_ID", "PROVINCE_NAME", "OWNER_DISTRICT_ID", "DISTRICT_NAME", "OWNER_DEVISION_UNIT_ID", "DEVISION_UNIT_NAME", "OWNER_MICRO_DISTRICT_ID", "MICRO_DISTRICT_NAME", "OWNER_STREET", "OWNER_APARTMENT_NO", "OWNER_DOOR_NO", "OWNER_GENDER", "OWNER_HOMEPHONE", "OWNER_WORKPHONE", "OWNER_CELLPHONE", "ADDRESS_DETAIL", "PHONE_NO", "GENDER", "START_DATE", "FIRSTNAME", "OWNER1_ID", "RFID_TAG", "IS_CERT_REVOKE", "INS_CREATED_BY", "INS_CREATED_DATE", "INSP_AMOUNT", "INSP_VAT", "MODIFICATION_ID", "RFT_IS_ACTIVE") AS 
  SELECT
    VEH.ID,
    VEH.PLATE_NO,
    VEH.CABIN_NO,
    VEH.ENGINE_NO,
    VEH.DECLARATION_NO,
    VEH.BUILD_YEAR,
    VEH.BUILD_MONTH,
    VEH.IMPORT_DATE,
    VEH.CERTIFICATE_NO,
    VEH.COLOR_ID,
    CO.NAME COLOR_NAME,
    PU.PURPOSE_BASE_ID,
    PU.ID PURPOSE_ID,
    PU.NAME PURPOSE_NAME,
    MM.VEHICLE_TYPE_ID,
    VT.NAME VEHICLE_TYPE_NAME,    
    MA.COUNTRY_ID,
    CY.NAME COUNTRY_NAME,
    MO.MARK_ID,
    MA.NAME MARK_NAME,
    MM.MODEL_ID,
    MO.NAME MODEL_NAME,   
    MM.VIN_NO,
    MM.MODIFICACE_NAME,
    VEH.SPECIAL_ID,
    SP.NAME SPECIAL_NAME,
    VEH.STEERING_TYPE_ID,
    ST.NAME STEERING_TYPE_NAME,
    MM.ENGINE_MODEL_ID,
    REM.NAME ENGINE_MODEL_NAME,
    CASE WHEN (PU.ID!=8 AND  REM.ENGINE_CAPACITY IS NULL) THEN VEH.FOR_TAX ELSE REM.ENGINE_CAPACITY END ENGINE_CAPACITY,
    FT.PARENT_ID FUEL_PARENT_TYPE_ID,
    FT.ID FUEL_TYPE_ID,
    FT.NAME || (CASE WHEN MM.IS_HYBRID=1 THEN ' - Цахилгаан' ELSE NULL END) FUEL_NAME,
    REM.ECO_CLASS_ID,
    EC.NAME ECO_CLASS_NAME,
    VEH.PAR_MARKER_ID,
    PA.NAME PAR_TYPE_NAME,
    MM.CLASSIFICATION_ID,
    CL.NAME CLASS_NAME,
    VEH.WHEEL_ID,
    WH.NAME WHEEL_NAME,
    MM.AXLE_COUNT,
    MM.SEAT_COUNT,
    MM.DOOR_COUNT,
    MM.OWN_WEIGHT,
    MM.MAX_LOAD,
    MM.TOTAL_WEIGHT,
    MM.HEIGHT,
    MM.WIDTH,
    MM.LENGTH,
    MM.IS_HYBRID,
    VEH.IS_ENABLED,
    VEH.IS_PENDING,
    VEH.ARCHIVE_NO,
    VEH.FIRST_ARCHIVE_NO,
    VEH.PAGE_COUNT,
    VEH.DESCRIPTION,
    VEH.CREATED_BY,
    VEH.CREATED_DATE,
    VEH.UPDATED_BY,
    VEH.UPDATED_DATE,
    VEH.IS_STOLEN,
    VEH.IS_WARNING,
    VEH.STATUS,
    STA.NAME STATUS_NAME,
    VEH.OWNER_ID,
    OV.COUNTRY_ID OWNER_COUNTRY,
    OV.COUNTRY OWNER_COUNTRY_NAME,
    OV.OWNER_TYPE_ID,
    OV.NAME OWNER_TYPE_NAME,
    OV.FAMILY_NAME,
    OV.LAST_NAME,
    OV.FIRST_NAME,
    OV.REGISTER_NO,
    OV.PROVINCE_ID OWNER_PROVINCE_ID,
    OV.PROVINCE_NAME, 
    OV.DISTRICT_ID OWNER_DISTRICT_ID,
    OV.DISTRICT_NAME, 
    OV.DEVISION_UNIT_ID OWNER_DEVISION_UNIT_ID,
    OV.DEVISION_UNIT_NAME, 
    OV.MICRO_DISTRICT_ID OWNER_MICRO_DISTRICT_ID,
    OV.MICRO_DISTRICT_NAME,
    OV.STREET OWNER_STREET,
    OV.APARTMENT_NO OWNER_APARTMENT_NO,
    OV.DOOR_NO OWNER_DOOR_NO,
    OV.GENDER OWNER_GENDER,
    OV.HOMEPHONE OWNER_HOMEPHONE,
    OV.WORKPHONE OWNER_WORKPHONE,
    OV.CELLPHONE OWNER_CELLPHONE,
    OV.ADDRESS ADDRESS_DETAIL,
    OV.PHONE_NO,
    CASE WHEN OV.GENDER=1 THEN 'Эрэгтэй' WHEN OV.GENDER=2 THEN 'Эмэгтэй' ELSE NULL END GENDER,
    ROWSH.START_DATE,
    SYSU.FIRSTNAME,
    VEH.OWNER1_ID,
    VEH.TID RFID_TAG,
    VEH.IS_CERT_REVOKE,
    VEH.INS_CREATED_BY,    
    VEH.INS_CREATED_DATE,
    --PS.TOTAL_AMOUNT INSP_AMOUNT,
    --PS.VAT_AMOUNT INSP_VAT
    NULL INSP_AMOUNT,
    NULL INSP_VAT,
    MM.ID modification_id,
     RFT.IS_ACTIVE AS RFT_IS_ACTIVE
FROM
    VRS.REG_VEHICLE VEH
LEFT JOIN VRS.REF_COLOR CO ON VEH.COLOR_ID=CO.ID
LEFT JOIN VRS.REG_MODIPICACE MM ON VEH.MODEL_ID=MM.ID
LEFT JOIN VRS.REG_MODEL MO ON MM.MODEL_ID=MO.ID
LEFT JOIN VRS.REG_MARK MA ON MO.MARK_ID=MA.ID
LEFT JOIN VRS.REG_VEHICLE_TYPE VT ON MM.VEHICLE_TYPE_ID=VT.ID
LEFT JOIN VRS.REF_COUNTRY CY ON MA.COUNTRY_ID=CY.ID
LEFT JOIN VRS.REF_PURPOSE PU ON VT.PURPOSE_ID=PU.ID
LEFT JOIN VRS.REF_GENERAL SP ON VEH.SPECIAL_ID=SP.ID
LEFT JOIN VRS.REF_GENERAL ST ON VEH.STEERING_TYPE_ID=ST.ID
LEFT JOIN VRS.REF_GENERAL PA ON VEH.PAR_MARKER_ID=PA.ID
LEFT JOIN VRS.REF_GENERAL WH ON VEH.WHEEL_ID=WH.ID
LEFT JOIN VRS.REF_ENGINE_MODEL REM ON MM.ENGINE_MODEL_ID=REM.ID
LEFT JOIN VRS.REF_GENERAL EC ON REM.ECO_CLASS_ID=EC.ID
LEFT JOIN VRS.REF_GENERAL FT ON REM.FUEL_TYPE_ID=FT.ID
LEFT JOIN VRS.REF_GENERAL CL ON MM.CLASSIFICATION_ID=CL.ID
LEFT JOIN VRS.REG_OWNER_VIEW OV ON VEH.OWNER_ID=OV.ID
LEFT JOIN VRS.REG_VEHICLE_OWNERSHIP ROWSH ON VEH.OWNER_ID=ROWSH.OWNER_ID AND VEH.ID=ROWSH.VEHICLE_ID
LEFT JOIN VRS.REG_STATUS STA ON VEH.STATUS=STA.ID
LEFT JOIN VRS.SYSTEM_USER SYSU ON VEH.UPDATED_BY=SYSU.ID 

LEFT JOIN VRS.REG_RFID_TAG RFT ON VEH.ID=RFT.VEHICLE_ID AND RFT.IS_ACTIVE=1

--LEFT JOIN MVIS.PAY_SERVICE_TARIFF_GROUP_VIEW PS ON (PS.ID=1 AND PS.PURPOSE_ID=PU.PURPOSE_BASE_ID)
WHERE ROWSH.END_DATE IS NULL
;
  GRANT MERGE VIEW ON "VRS"."REG_VEHICLE_VIEW" TO "MVIS" WITH GRANT OPTION;
  GRANT FLASHBACK ON "VRS"."REG_VEHICLE_VIEW" TO "MVIS" WITH GRANT OPTION;
  GRANT DEBUG ON "VRS"."REG_VEHICLE_VIEW" TO "MVIS" WITH GRANT OPTION;
  GRANT QUERY REWRITE ON "VRS"."REG_VEHICLE_VIEW" TO "MVIS" WITH GRANT OPTION;
  GRANT ON COMMIT REFRESH ON "VRS"."REG_VEHICLE_VIEW" TO "MVIS" WITH GRANT OPTION;
  GRANT REFERENCES ON "VRS"."REG_VEHICLE_VIEW" TO "MVIS" WITH GRANT OPTION;
  GRANT UPDATE ON "VRS"."REG_VEHICLE_VIEW" TO "MVIS" WITH GRANT OPTION;
  GRANT INSERT ON "VRS"."REG_VEHICLE_VIEW" TO "MVIS" WITH GRANT OPTION;
  GRANT DELETE ON "VRS"."REG_VEHICLE_VIEW" TO "MVIS" WITH GRANT OPTION;
  GRANT SELECT ON "VRS"."REG_VEHICLE_VIEW" TO "MVIS" WITH GRANT OPTION;
  GRANT MERGE VIEW ON "VRS"."REG_VEHICLE_VIEW" TO "USER_INSP";
  GRANT FLASHBACK ON "VRS"."REG_VEHICLE_VIEW" TO "USER_INSP";
  GRANT DEBUG ON "VRS"."REG_VEHICLE_VIEW" TO "USER_INSP";
  GRANT QUERY REWRITE ON "VRS"."REG_VEHICLE_VIEW" TO "USER_INSP";
  GRANT ON COMMIT REFRESH ON "VRS"."REG_VEHICLE_VIEW" TO "USER_INSP";
  GRANT REFERENCES ON "VRS"."REG_VEHICLE_VIEW" TO "USER_INSP";
  GRANT UPDATE ON "VRS"."REG_VEHICLE_VIEW" TO "USER_INSP";
  GRANT SELECT ON "VRS"."REG_VEHICLE_VIEW" TO "USER_INSP";
  GRANT INSERT ON "VRS"."REG_VEHICLE_VIEW" TO "USER_INSP";
  GRANT DELETE ON "VRS"."REG_VEHICLE_VIEW" TO "USER_INSP";
  GRANT SELECT ON "VRS"."REG_VEHICLE_VIEW" TO "USER_NDC";
  GRANT SELECT ON "VRS"."REG_VEHICLE_VIEW" TO "USER_READER";
  GRANT SELECT ON "VRS"."REG_VEHICLE_VIEW" TO "USER_EMONGOL";
--------------------------------------------------------
--  DDL for View SERIES_AUCTION_VIEW
--------------------------------------------------------

  CREATE OR REPLACE FORCE EDITIONABLE VIEW "VRS"."SERIES_AUCTION_VIEW" ("ID", "NAME", "SERIES_ID", "SERIES_NAME", "PROVINCE_ID", "PROVINCE_NAME") AS 
  SELECT 
    SN.ID, SN.NAME, 
    S.ID SERIES_ID, S.NAME SERIES_NAME, 
    S.PROVINCE_ID, AP.NAME PROVINCE_NAME 
FROM VRS.SERIES_NUMBER SN
INNER JOIN VRS.SERIES S ON SN.SERIES_ID=S.ID
INNER JOIN VRS.ADDRESS_PROVINCE AP ON S.PROVINCE_ID=AP.ID
WHERE SN.ORDER_USER='Auction' AND SN.TYPE=1 AND SN.VEHICLE_ID IS NULL
;
  GRANT SELECT ON "VRS"."SERIES_AUCTION_VIEW" TO "USER_INSP";
--------------------------------------------------------
--  DDL for View SERIES_INTERVAL_VIEW
--------------------------------------------------------

  CREATE OR REPLACE FORCE EDITIONABLE VIEW "VRS"."SERIES_INTERVAL_VIEW" ("ID", "SERIES_ID", "DEPARTMENT_ID", "POSITION_ID", "FROM_NUMBER", "TO_NUMBER", "TYPE_NAME", "IS_LOCAL", "LOCAL_USER_ID", "NAME", "PROVINCE", "FIRSTNAME", "LASTNAME", "DEPARTMENT", "POSITION", "CREATE_DATE", "IS_ORDER", "IS_OPENED", "IS_AUTO") AS 
  SELECT 
    SI.ID, 
    S."ID" SERIES_ID,
    SD.ID DEPARTMENT_ID,
    Sp.ID POSITION_ID,
    SI.FROM_NUMBER,
    SI.To_NUMBER,
    SI.NAME "TYPE_NAME",
    SI.IS_LOCAL,
    SI.LOCAL_USER_ID,
	S.NAME,
	AP.NAME PROVINCE,
    MU.FIRSTNAME,
    MU.LASTNAME,
    SD.NAME DEPARTMENT,
    SP.NAME POSITION,
    SI.CREATE_DATE,
    CASE WHEN SI.IS_ORDER=0 THEN 'ҮГҮЙ' ELSE 'ТИЙМ' END IS_ORDER,
    CASE WHEN SI.IS_OPENED=0 THEN 'ҮГҮЙ' ELSE 'ТИЙМ' END IS_OPENED,
    CASE WHEN SI.IS_AUTO=0 THEN 'ҮГҮЙ' ELSE 'ТИЙМ' END IS_AUTO
FROM VRS.SERIES_INTERVAL SI
LEFT JOIN VRS.SERIES S ON SI.SERIES_ID=S.ID
LEFT JOIN VRS.ADDRESS_PROVINCE AP ON S.PROVINCE_ID=AP.ID
LEFT JOIN VRS.SYSTEM_USER MU ON SI.LOCAL_USER_ID = MU.ID
LEFT JOIN VRS.SYSTEM_DEPARTMENT SD ON MU.USERDEPARTMENTID = SD.ID
LEFT JOIN VRS.SYSTEM_POSITION SP ON MU.USERPOSITIONID = SP.ID
;
--------------------------------------------------------
--  DDL for View SERIES_NUMBER_VIEW
--------------------------------------------------------

  CREATE OR REPLACE FORCE EDITIONABLE VIEW "VRS"."SERIES_NUMBER_VIEW" ("ID", "WEEKEND", "NAME", "ORDER_DATE", "IS_ORDER", "IS_GIVEN", "SHOW_DATE", "PROVINCE_ID", "INTERVAL_NAME") AS 
  SELECT 
    SN.ID, SUBSTR(SN.NO,-1, LENGTH(SN.NO)) WEEKEND ,SN.NAME, SN.ORDER_DATE, SN.IS_ORDER, SN.IS_GIVEN, SN.SHOW_DATE, S.PROVINCE_ID, SI.NAME INTERVAL_NAME
FROM SERIES_NUMBER SN
    INNER JOIN SERIES S ON SN.SERIES_ID = S.ID
    INNER JOIN SERIES_INTERVAL SI ON S.ID=SI.SERIES_ID
WHERE    
    S.TYPE=1 AND
    SI.NAME != 'SEND' AND 
    SI.IS_OPENED=1 AND
    SI.IS_ORDER=1 AND
    SI.IS_HIDDEN=0 AND
    SN.IS_LOCAL=0 AND
    SN.IS_HIDDEN=0 AND
    SN.IS_OPENED=1
ORDER BY SN.NAME ASC
;
--------------------------------------------------------
--  DDL for View SERIES_VIEW
--------------------------------------------------------

  CREATE OR REPLACE FORCE EDITIONABLE VIEW "VRS"."SERIES_VIEW" ("ID", "NAME", "PROVINCE", "TYPE", "TYPE_ID", "IS_DUPLICATE", "IS_CHECK", "IS_OLD") AS 
  SELECT 
    SR.ID, 
    SR.NAME,
    AP.NAME PROVINCE,
    RP.NAME TYPE,
    RP.ID TYPE_ID,
    CASE WHEN SR.IS_DUPLICATE=0 THEN 'ҮГҮЙ' ELSE 'ТИЙМ' END IS_DUPLICATE,
    CASE WHEN SR.IS_CHECK_ADDRESS=0 THEN 'ҮГҮЙ' ELSE 'ТИЙМ' END IS_CHECK,
    CASE WHEN SR.IS_OLD=0 THEN 'ҮГҮЙ' ELSE 'ТИЙМ' END IS_OLD
FROM VRS.SERIES SR
LEFT JOIN VRS.ADDRESS_PROVINCE AP ON SR.PROVINCE_ID=AP.ID
LEFT JOIN VRS.VEHICLE_TYPE RP ON SR.TYPE=RP.ID
ORDER BY SR.NAME ASC
;
--------------------------------------------------------
--  DDL for View SYSTEM_DEPARTMENT_ARCHIVE
--------------------------------------------------------

  CREATE OR REPLACE FORCE EDITIONABLE VIEW "VRS"."SYSTEM_DEPARTMENT_ARCHIVE" ("ID", "PROVINCE", "DEPARTMENT", "ARCHIVE", "ABBR", "DELETED_AT") AS 
  SELECT 
    SA.ID, 
    AP.NAME PROVINCE,
    SD.NAME DEPARTMENT,
    SA.ARCHIVE,
    SA.ABBR,
    SA.DELETED_AT
FROM VRS.SYSTEM_ARCHIVE SA
LEFT JOIN VRS.ADDRESS_PROVINCE AP ON SA.PROVINCEID=AP.ID
LEFT JOIN VRS.SYSTEM_DEPARTMENT SD ON SA.DEPARTMENTID=SD.ID
;
--------------------------------------------------------
--  DDL for View SYSTEM_POSITION_LOG_VIEW
--------------------------------------------------------

  CREATE OR REPLACE FORCE EDITIONABLE VIEW "VRS"."SYSTEM_POSITION_LOG_VIEW" ("POSITION_ID", "OLD_POSITION_NAME", "CREATED_USER_ID", "UPDATED_USER_ID", "CREATEDDATE", "POSITION_NAME", "OP_NAME", "FIRSTNAME", "LASTNAME", "U_FIRSTNAME", "U_LASTNAME") AS 
  SELECT 
 POS.POSITION_ID,
 POS.NAME OLD_POSITION_NAME,
 CU."ID" CREATED_USER_ID,
 UU."ID" UPDATED_USER_ID,
 POS.CREATEDDATE CREATEDDATE,
 SP.NAME POSITION_NAME,
 CASE POS.TYPE_ID WHEN 1 THEN SM.NAME ELSE SE.NAME END OP_NAME,
 CU.FIRSTNAME,
 CU.LASTNAME,
 UU.FIRSTNAME U_FIRSTNAME,
 UU.LASTNAME U_LASTNAME
FROM 
SYSTEM_POSITION_LOG POS
LEFT JOIN VRS.SYSTEM_POSITION SP ON POS.POSITION_ID=SP.ID
LEFT JOIN VRS.SYSTEM_SERVICE SE ON POS.ACTION_ID=SE.ID
LEFT JOIN VRS.SYSTEM_MENU SM ON POS.ACTION_ID=SM.ID
LEFT JOIN VRS.SYSTEM_USER UU ON POS.UPDATEDBY=UU.ID
LEFT JOIN VRS.SYSTEM_USER CU ON POS.CREATEDBY=CU.ID
;
--------------------------------------------------------
--  DDL for View SYSTEM_USER_MENU_VIEW
--------------------------------------------------------

  CREATE OR REPLACE FORCE EDITIONABLE VIEW "VRS"."SYSTEM_USER_MENU_VIEW" ("ID", "NAME", "ACTION_ID", "POSITION_ID", "TYPE_ID", "MENUORDER") AS 
  SELECT
    SM."ID",
    SM."NAME",
    UM.ACTION_ID,
    UM.POSITION_ID,
    UM.TYPE_ID,
    SM.ORDR MENUORDER
FROM
    VRS.SYSTEM_MENU SM
LEFT JOIN VRS.SYSTEM_USER_MENU UM ON SM.ID=UM.ACTION_ID
WHERE UM.POSITION_ID = 8 OR UM.POSITION_ID IS NULL
;
--------------------------------------------------------
--  DDL for View TEST_VIEW
--------------------------------------------------------

  CREATE OR REPLACE FORCE EDITIONABLE VIEW "VRS"."TEST_VIEW" ("ID", "MARK_NAME", "COLOR_NAME", "BUILD_YEAR", "ENGINE_CAPACITY", "IMPORT_DATE", "PLATE_NO", "PURPOSE_NAME", "WHEEL_NAME", "CABIN_NO", "VEHICLE_TYPE_NAME", "DECLARATION_NO", "CERTIFICATE_NO", "CLASS_NAME", "COUNTRY_NAME", "FUEL_NAME", "MODEL_NAME", "ENGINE_NO", "VIN_NO", "MODIFICACE_NAME", "ULS", "AIMAG", "SOUM", "BAG", "OWNER_TYPE_NAME", "GENDER", "UPDATED_DATE") AS 
  SELECT 
                RV.ID,
                MM.MARK_NAME,
                CO.NAME COLOR_NAME,
                RV.BUILD_YEAR,
                MM.CAPACITY ENGINE_CAPACITY,
                RV.IMPORT_DATE,
                RV.PLATE_NO,
                MM.PURPOSE_NAME,
                WH.NAME WHEEL_NAME,
                RV.CABIN_NO,
                MM.VEHICLE_TYPE_NAME,
                RV.DECLARATION_NO,
                RV.CERTIFICATE_NO,
                MM.CLASS_NAME,
                MM.COUNTRY_NAME,
                MM.FT_NAME || (CASE WHEN MM.IS_HYBRID=1 THEN ' - Цахилгаан' ELSE NULL END) FUEL_NAME,
                MM.MODEL_NAME,
                RV.ENGINE_NO,
                MM.VIN_NO,
                MM.MODIFICACE_NAME,
                OV.COUNTRY ULS,
                OV.PROVINCE_NAME AIMAG,
                OV.DISTRICT_NAME SOUM,
                OV.DEVISION_UNIT_NAME BAG,
                OV.NAME OWNER_TYPE_NAME,
                CASE WHEN OV.GENDER=1 THEN 'Эр' WHEN OV.GENDER=2 THEN 'Эм' ELSE NULL END GENDER,
                To_CHAR(GREATEST(NVL(RV.UPDATED_DATE,TO_DATE('2009-01-02','YYYY-MM-DD')),NVL(RV.INS_UPDATED_DATE,To_DATE('2009-01-01','YYYY-MM-DD'))),'YYYY-MM-DD HH24:MI:SS') UPDATED_DATE
            FROM VRS.REG_VEHICLE RV
            LEFT JOIN VRS.REF_COLOR CO ON RV.COLOR_ID=CO.ID
            LEFT JOIN VRS.REG_MODIPICACE_VIEW MM ON RV.MODEL_ID=MM.ID
            LEFT JOIN VRS.REF_GENERAL WH ON RV.WHEEL_ID=WH.ID
            LEFT JOIN VRS.REG_OWNER_VIEW OV ON RV.OWNER_ID=OV.ID
            LEFT JOIN VRS.REG_VEHICLE_OWNERSHIP ROWSH ON RV.OWNER_ID=ROWSH.OWNER_ID AND RV.ID=ROWSH.VEHICLE_ID AND ROWSH.END_DATE IS NULL
;
--------------------------------------------------------
--  DDL for View TOTAL_VEHICLE_VIEW
--------------------------------------------------------

  CREATE OR REPLACE FORCE EDITIONABLE VIEW "VRS"."TOTAL_VEHICLE_VIEW" ("ID", "FIRST_ARCHIVE_NO", "PURPOSE_ID", "CREATED_DATE", "PURPOSE_NAME") AS 
  SELECT 
veh.ID,
veh.FIRST_ARCHIVE_NO,
pu."ID" PURPOSE_ID,
veh."CREATED_DATE",
pu.name "PURPOSE_NAME" 
FROM VRS.reg_vehicle veh 
LEFT JOIN VRS.REG_MODIPICACE MM ON VEH.MODEL_ID=MM.ID 
LEFT JOIN VRS.REG_VEHICLE_TYPE VT ON MM.VEHICLE_TYPE_ID=VT.ID 
LEFT JOIN VRS.REF_PURPOSE PU ON VT.PURPOSE_ID=PU.ID
;
--------------------------------------------------------
--  DDL for View VEHICLE_OWNER_REF
--------------------------------------------------------

  CREATE OR REPLACE FORCE EDITIONABLE VIEW "VRS"."VEHICLE_OWNER_REF" ("ID", "PLATE_NO", "CABIN_NO", "CERTIFICATE_NO", "STATUS", "COLOR_NAME", "MARK_NAME", "MODEL_NAME", "STATUS_NAME", "OWNER_ID", "LAST_NAME", "FIRST_NAME", "REGISTER_NO", "START_DATE", "END_DATE", "STATUS_ID") AS 
  SELECT
    veh."ID",
    veh."PLATE_NO",
    veh."CABIN_NO",
    veh."CERTIFICATE_NO",
    veh."STATUS",
    co.name color_name,
    ma.name mark_name,
    mo.name model_name,
    STA.NAME STATUS_NAME,
    VEH_OW.OWNER_ID,
    OW.LAST_NAME,
    OW.FIRST_NAME,
    OW.REGISTER_NO,
    VEH_OW.START_DATE,
    VEH_OW.END_DATE,
    VEH.STATUS STATUS_ID
FROM
    VRS.REG_VEHICLE_OWNERSHIP VEH_OW
LEFT JOIN VRS.REG_VEHICLE VEH ON VEH_OW.VEHICLE_ID=VEH.ID
LEFT JOIN VRS.REG_MODIPICACE MM ON VEH.MODEL_ID=MM.ID
LEFT JOIN VRS.REG_MODEL MO ON MM.MODEL_ID=MO.ID
LEFT JOIN VRS.REG_MARK MA ON MO.MARK_ID=MA.ID
LEFT JOIN VRS.REF_COLOR CO ON VEH.COLOR_ID=CO.ID
LEFT JOIN VRS.OWNER OW ON VEH_OW.OWNER_ID=OW.ID
LEFT JOIN VRS.REG_STATUS STA ON veh.STATUS=STA.ID
WHERE VEH.ID IS NOT NULL
;
--------------------------------------------------------
--  DDL for View VIEW1
--------------------------------------------------------

  CREATE OR REPLACE FORCE EDITIONABLE VIEW "VRS"."VIEW1" ("ID", "VEHICLE_ID", "PLATE_NO", "CABIN_NO", "IS_ENABLED", "IS_PENDING", "VIN_NO", "ENGINE_NO", "COLOR_ID", "CERTIFICATE_NO", "IMPORT_DATE", "DECLARATION_NO", "MARK_ID", "MODEL_ID", "VEHICLE_TYPE_ID", "COUNTRY_ID", "PURPOSE_ID", "ECO_CLASS_ID", "BUILD_YEAR", "BUILD_MONTH", "MAX_LOAD", "OWNER_ID", "ARCHIVE_NO", "FIRST_ARCHIVE_NO", "PAGE_COUNT", "DESCRIPTION", "STATUS", "CREATED_BY", "CREATED_DATE", "UPDATED_BY", "UPDATED_DATE", "IS_STOLEN", "IS_WARNING", "COLOR_NAME", "MARK_NAME", "MODEL_NAME", "VEHICLE_TYPE_NAME", "COUNTRY_NAME", "PURPOSE_NAME", "SPECIAL_NAME", "CLASSIFICATION_ID", "MODIFICACE_NAME", "IS_HYBRID", "FUEL_PARENT_TYPE_ID", "FUEL_NAME", "ENGINE_MODEL_ID", "ENGINE_MODEL_NAME", "ENGINE_CAPACITY") AS 
  SELECT
    veh."ID",
    RVEH.ID VEHICLE_ID,
    veh."PLATE_NO",
    VEH."CABIN_NO",
    VEH."IS_ENABLED",
    VEH."IS_PENDING",
    MM."VIN_NO",
    VEH."ENGINE_NO",
    VEH."COLOR_ID",
    VEH."CERTIFICATE_NO",
    RVEH."IMPORT_DATE",
    RVEH."DECLARATION_NO",
    MO."MARK_ID",
    VEH."MODEL_ID",
    MM."VEHICLE_TYPE_ID",
    MA."COUNTRY_ID",
    pu."ID" PURPOSE_ID,
    REM."ECO_CLASS_ID",
    VEH."BUILD_YEAR",
    VEH."BUILD_MONTH",
    MM."MAX_LOAD",
    VEH."OWNER_ID",
    VEH."ARCHIVE_NO",
    VEH."FIRST_ARCHIVE_NO",
    VEH."PAGE_COUNT",
    VEH."DESCRIPTION",
    veh."STATUS",
    VEH."CREATED_BY",
    VEH."CREATED_DATE",
    VEH."UPDATED_BY",
    VEH."UPDATED_DATE",
    VEH.IS_STOLEN,
    VEH."IS_WARNING",
    co.name color_name,
    ma.name mark_name,
    mo.name model_name,
    vt.name vehicle_type_name,
    cy.name country_name,
    pu.name purpose_name,
    sp.name special_name,
    mm."CLASSIFICATION_ID",
    mm."MODIFICACE_NAME",
    mm."IS_HYBRID",
    FT.parent_id FUEL_PARENT_TYPE_ID,
    FT.name fuel_name,
    VEH.ENGINE_MODEL_ID,
    rem.NAME ENGINE_MODEL_NAME,
    rem.ENGINE_CAPACITY
FROM
    VRS.reg_vehicle_archive veh
LEFT JOIN VRS.REG_VEHICLE RVEH ON VEH.VEHICLE_ID=RVEH.ID
LEFT JOIN VRS.REF_COLOR CO ON veh.COLOR_ID=CO.ID
LEFT JOIN VRS.REG_MODIPICACE MM ON veh.INSERT_MODEL_ID=MM.ID
LEFT JOIN VRS.REG_MODEL MO ON MM.MODEL_ID=MO.ID
LEFT JOIN VRS.REG_MARK MA ON MO.MARK_ID=MA.ID
LEFT JOIN VRS.REG_VEHICLE_TYPE VT ON MM.VEHICLE_TYPE_ID=VT.ID
LEFT JOIN VRS.REF_COUNTRY CY ON MA.COUNTRY_ID=CY.ID
LEFT JOIN VRS.REF_PURPOSE PU ON VT.PURPOSE_ID=PU.ID
LEFT JOIN VRS.REF_GENERAL SP ON VEH.SPECIAL_ID=SP.ID
LEFT JOIN VRS.REF_GENERAL ST ON VEH.STEERING_TYPE_ID=ST.ID
LEFT JOIN VRS.REF_GENERAL WH ON VEH.WHEEL_ID=WH.ID
LEFT JOIN VRS.REF_ENGINE_MODEL REM ON VEH.ENGINE_MODEL_ID=REM.ID
LEFT JOIN VRS.REF_GENERAL EC ON REM.ECO_CLASS_ID=EC.ID
LEFT JOIN VRS.REF_GENERAL FT ON REM.FUEL_TYPE_ID=FT.ID
LEFT JOIN VRS.REF_GENERAL CL ON mm.CLASSIFICATION_ID=CL.ID
LEFT JOIN VRS.REG_STATUS STA ON VEH.STATUS=STA.ID
;
--------------------------------------------------------
--  DDL for Index ADDRESS_PROVINCE_NEW_PK
--------------------------------------------------------

  CREATE UNIQUE INDEX "VRS"."ADDRESS_PROVINCE_NEW_PK" ON "VRS"."ADDRESS_PROVINCE" ("ID") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "USERS" ;
--------------------------------------------------------
--  DDL for Index SYS_C00194187
--------------------------------------------------------

  CREATE UNIQUE INDEX "VRS"."SYS_C00194187" ON "VRS"."ADDRESS_SUBDEV" ("ID") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_INDEX" ;
--------------------------------------------------------
--  DDL for Index SYS_C00194189
--------------------------------------------------------

  CREATE UNIQUE INDEX "VRS"."SYS_C00194189" ON "VRS"."ADDRESS_SUBDEV_UNIT" ("ID") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_INDEX" ;
--------------------------------------------------------
--  DDL for Index OWNER_PK
--------------------------------------------------------

  CREATE UNIQUE INDEX "VRS"."OWNER_PK" ON "VRS"."OWNER" ("ID") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "USERS" ;
--------------------------------------------------------
--  DDL for Index ESIGN_INDEX1
--------------------------------------------------------

  CREATE INDEX "VRS"."ESIGN_INDEX1" ON "VRS"."ESIGN" ("ID") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "USERS" ;
--------------------------------------------------------
--  DDL for Index SYSTEM_PLATE_FACTORY_PK
--------------------------------------------------------

  CREATE UNIQUE INDEX "VRS"."SYSTEM_PLATE_FACTORY_PK" ON "VRS"."SYSTEM_PLATE_FACTORY" ("ID") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_INDEX" ;
--------------------------------------------------------
--  DDL for Index SYSTEM_PRINTER_PK
--------------------------------------------------------

  CREATE UNIQUE INDEX "VRS"."SYSTEM_PRINTER_PK" ON "VRS"."SYSTEM_PRINTER" ("ID") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_INDEX" ;
--------------------------------------------------------
--  DDL for Index REF_ENGINE_MODEL_PK
--------------------------------------------------------

  CREATE UNIQUE INDEX "VRS"."REF_ENGINE_MODEL_PK" ON "VRS"."REF_ENGINE_MODEL" ("ID") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_INDEX" ;
--------------------------------------------------------
--  DDL for Index REG_REFERENCE_LOG_PK
--------------------------------------------------------

  CREATE UNIQUE INDEX "VRS"."REG_REFERENCE_LOG_PK" ON "VRS"."REG_REFERENCE_LOG" ("ID") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_INDEX" ;
--------------------------------------------------------
--  DDL for Index EPAY_TRANSACTION_PK
--------------------------------------------------------

  CREATE UNIQUE INDEX "VRS"."EPAY_TRANSACTION_PK" ON "VRS"."EPAY_TRANSACTION" ("ID") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "USERS" ;
--------------------------------------------------------
--  DDL for Index ADDRESS_MICRODISTRICT_PK
--------------------------------------------------------

  CREATE UNIQUE INDEX "VRS"."ADDRESS_MICRODISTRICT_PK" ON "VRS"."ADDRESS_MICRODISTRICT" ("ID") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_INDEX" ;
--------------------------------------------------------
--  DDL for Index SYSTEM_DEPTYPE_PK
--------------------------------------------------------

  CREATE UNIQUE INDEX "VRS"."SYSTEM_DEPTYPE_PK" ON "VRS"."SYSTEM_DEPTYPE" ("ID") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_INDEX" ;
--------------------------------------------------------
--  DDL for Index REG_RFID_TAG_PHOTO_PK
--------------------------------------------------------

  CREATE UNIQUE INDEX "VRS"."REG_RFID_TAG_PHOTO_PK" ON "VRS"."REG_RFID_TAG_PHOTO" ("ID") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  TABLESPACE "USERS" ;
--------------------------------------------------------
--  DDL for Index TABLE1_PK
--------------------------------------------------------

  CREATE UNIQUE INDEX "VRS"."TABLE1_PK" ON "VRS"."TRANSACTION" ("ID") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "USERS" ;
--------------------------------------------------------
--  DDL for Index REG_PLATENUMBER_SAVE_ORDER_PK
--------------------------------------------------------

  CREATE UNIQUE INDEX "VRS"."REG_PLATENUMBER_SAVE_ORDER_PK" ON "VRS"."REG_PLATENUMBER_SAVE_ORDER" ("ID") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "USERS" ;
--------------------------------------------------------
--  DDL for Index REG_STATUS_PK
--------------------------------------------------------

  CREATE UNIQUE INDEX "VRS"."REG_STATUS_PK" ON "VRS"."REG_STATUS" ("ID") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_INDEX" ;
--------------------------------------------------------
--  DDL for Index SYSTEM_ARCHIVE_PKID_PK
--------------------------------------------------------

  CREATE UNIQUE INDEX "VRS"."SYSTEM_ARCHIVE_PKID_PK" ON "VRS"."SYSTEM_ARCHIVE" ("ID") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_INDEX" ;
--------------------------------------------------------
--  DDL for Index USER_GERCHILGEE_OLGOLT_PK
--------------------------------------------------------

  CREATE UNIQUE INDEX "VRS"."USER_GERCHILGEE_OLGOLT_PK" ON "VRS"."REG_CERTIFICATE" ("ID") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_INDEX" ;
--------------------------------------------------------
--  DDL for Index REG_LIMITED_PK
--------------------------------------------------------

  CREATE UNIQUE INDEX "VRS"."REG_LIMITED_PK" ON "VRS"."REG_LIMITED" ("ID") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_INDEX" ;
--------------------------------------------------------
--  DDL for Index REG_VEHICLE_INSP_ARCHIVE_PK
--------------------------------------------------------

  CREATE UNIQUE INDEX "VRS"."REG_VEHICLE_INSP_ARCHIVE_PK" ON "VRS"."REG_VEHICLE_INSP_ARCHIVE" ("ID") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_INDEX" ;
--------------------------------------------------------
--  DDL for Index REF_COLOR_PK
--------------------------------------------------------

  CREATE UNIQUE INDEX "VRS"."REF_COLOR_PK" ON "VRS"."REF_COLOR" ("ID") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_INDEX" ;
--------------------------------------------------------
--  DDL for Index SERIES_NUMBER_PK
--------------------------------------------------------

  CREATE UNIQUE INDEX "VRS"."SERIES_NUMBER_PK" ON "VRS"."SERIES_NUMBER" ("ID") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_INDEX" ;
--------------------------------------------------------
--  DDL for Index REG_VEHICLE_PK
--------------------------------------------------------

  CREATE UNIQUE INDEX "VRS"."REG_VEHICLE_PK" ON "VRS"."REG_VEHICLE" ("ID") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_INDEX" ;
--------------------------------------------------------
--  DDL for Index REF_PURPOSE_PK
--------------------------------------------------------

  CREATE UNIQUE INDEX "VRS"."REF_PURPOSE_PK" ON "VRS"."REF_PURPOSE" ("ID") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_INDEX" ;
--------------------------------------------------------
--  DDL for Index MAIN_USER_POSITION_ID_PK
--------------------------------------------------------

  CREATE UNIQUE INDEX "VRS"."MAIN_USER_POSITION_ID_PK" ON "VRS"."SYSTEM_POSITION" ("ID") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_INDEX" ;
--------------------------------------------------------
--  DDL for Index REG_MODIPICACE_PK
--------------------------------------------------------

  CREATE UNIQUE INDEX "VRS"."REG_MODIPICACE_PK" ON "VRS"."REG_MODIPICACE" ("ID") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_INDEX" ;
--------------------------------------------------------
--  DDL for Index REG_MODEL_PK1
--------------------------------------------------------

  CREATE UNIQUE INDEX "VRS"."REG_MODEL_PK1" ON "VRS"."REG_MODEL" ("ID") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_INDEX" ;
--------------------------------------------------------
--  DDL for Index SERIES_INTERVAL_PK
--------------------------------------------------------

  CREATE UNIQUE INDEX "VRS"."SERIES_INTERVAL_PK" ON "VRS"."SERIES_INTERVAL" ("ID") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_INDEX" ;
--------------------------------------------------------
--  DDL for Index REF_REFERENCE_ORG_PK
--------------------------------------------------------

  CREATE UNIQUE INDEX "VRS"."REF_REFERENCE_ORG_PK" ON "VRS"."REF_REFERENCE_ORG" ("ID") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_INDEX" ;
--------------------------------------------------------
--  DDL for Index REG_RFID_TAG_IDX
--------------------------------------------------------

  CREATE UNIQUE INDEX "VRS"."REG_RFID_TAG_IDX" ON "VRS"."REG_RFID_TAG" ("ID") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_INDEX" ;
--------------------------------------------------------
--  DDL for Index SYSTEM_POSITION_LOG_PK
--------------------------------------------------------

  CREATE UNIQUE INDEX "VRS"."SYSTEM_POSITION_LOG_PK" ON "VRS"."SYSTEM_POSITION_LOG" ("ID") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_INDEX" ;
--------------------------------------------------------
--  DDL for Index OWNER_STATUS_PK
--------------------------------------------------------

  CREATE UNIQUE INDEX "VRS"."OWNER_STATUS_PK" ON "VRS"."OWNER_STATUS" ("ID") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "USERS" ;
--------------------------------------------------------
--  DDL for Index REG_EXHAUST_NUMBER_PK
--------------------------------------------------------

  CREATE UNIQUE INDEX "VRS"."REG_EXHAUST_NUMBER_PK" ON "VRS"."REG_EXHAUST_NUMBER" ("ID") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  TABLESPACE "USERS" ;
--------------------------------------------------------
--  DDL for Index REG_VEHICLE_TYPE_IDX
--------------------------------------------------------

  CREATE INDEX "VRS"."REG_VEHICLE_TYPE_IDX" ON "VRS"."REG_VEHICLE_TYPE" ("PURPOSE_ID") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_INDEX" ;
--------------------------------------------------------
--  DDL for Index REG_VEHICLE_IDX
--------------------------------------------------------

  CREATE INDEX "VRS"."REG_VEHICLE_IDX" ON "VRS"."REG_VEHICLE" ("UPDATED_DATE", "MODEL_ID", "CREATED_DATE", "UPDATED_BY", "STEERING_TYPE_ID", "ENGINE_MODEL_ID", "PAR_MARKER_ID", "SPECIAL_ID", "COLOR_ID", "STATUS") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_INDEX" ;
--------------------------------------------------------
--  DDL for Index REG_VEHICLE_OWNER1
--------------------------------------------------------

  CREATE INDEX "VRS"."REG_VEHICLE_OWNER1" ON "VRS"."REG_VEHICLE" ("OWNER1_ID") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "USERS" ;
--------------------------------------------------------
--  DDL for Index REG_VEHICLE_ARCHIVE_PK
--------------------------------------------------------

  CREATE INDEX "VRS"."REG_VEHICLE_ARCHIVE_PK" ON "VRS"."REG_VEHICLE_ARCHIVE" ("ID") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_INDEX" ;
--------------------------------------------------------
--  DDL for Index SERIES_NUMBER_WHERE2
--------------------------------------------------------

  CREATE INDEX "VRS"."SERIES_NUMBER_WHERE2" ON "VRS"."SERIES_NUMBER" ("ISAUCTION") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "USERS" ;
--------------------------------------------------------
--  DDL for Index CREATED_BY_IDX
--------------------------------------------------------

  CREATE INDEX "VRS"."CREATED_BY_IDX" ON "VRS"."REG_PLATENUMBER_SAVE" ("CREATED_BY") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "USERS" ;
--------------------------------------------------------
--  DDL for Index REG_MARK_IDX
--------------------------------------------------------

  CREATE INDEX "VRS"."REG_MARK_IDX" ON "VRS"."REG_MARK" ("COUNTRY_ID") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_INDEX" ;
--------------------------------------------------------
--  DDL for Index ESIGN_INDEX3
--------------------------------------------------------

  CREATE INDEX "VRS"."ESIGN_INDEX3" ON "VRS"."ESIGN" ("OWNER_REGNUM") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "USERS" ;
--------------------------------------------------------
--  DDL for Index REF_PURPOSE_IDX
--------------------------------------------------------

  CREATE INDEX "VRS"."REF_PURPOSE_IDX" ON "VRS"."REF_PURPOSE" ("PURPOSE_BASE_ID") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_INDEX" ;
--------------------------------------------------------
--  DDL for Index OWNER_INDEX2
--------------------------------------------------------

  CREATE INDEX "VRS"."OWNER_INDEX2" ON "VRS"."OWNER" ("REGISTER_NO") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "USERS" ;
--------------------------------------------------------
--  DDL for Index LOG_UPDATED_UIDX
--------------------------------------------------------

  CREATE UNIQUE INDEX "VRS"."LOG_UPDATED_UIDX" ON "VRS"."LOG_UPDATED" ("ID") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "USERS" ;
--------------------------------------------------------
--  DDL for Index ADDRESS_SUBDEV_UNIT_INDEX1
--------------------------------------------------------

  CREATE INDEX "VRS"."ADDRESS_SUBDEV_UNIT_INDEX1" ON "VRS"."ADDRESS_SUBDEV_UNIT" ("ID", "DEVISION_ID") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "USERS" ;
--------------------------------------------------------
--  DDL for Index REG_VEHICLE_OWNERSHIP_IDX2
--------------------------------------------------------

  CREATE INDEX "VRS"."REG_VEHICLE_OWNERSHIP_IDX2" ON "VRS"."REG_VEHICLE_OWNERSHIP" ("VEHICLE_ID", "OWNER_ID") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_INDEX" ;
--------------------------------------------------------
--  DDL for Index ADDRESS_SUBDEV_UNIT_IDX
--------------------------------------------------------

  CREATE INDEX "VRS"."ADDRESS_SUBDEV_UNIT_IDX" ON "VRS"."ADDRESS_SUBDEV_UNIT_OLD" ("DEVISION_ID") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "USERS" ;
--------------------------------------------------------
--  DDL for Index REF_GENERAL_IDX
--------------------------------------------------------

  CREATE INDEX "VRS"."REF_GENERAL_IDX" ON "VRS"."REF_GENERAL" ("PARENT_ID", "REF_TYPE") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_INDEX" ;
--------------------------------------------------------
--  DDL for Index IDX4
--------------------------------------------------------

  CREATE INDEX "VRS"."IDX4" ON "VRS"."OWNER_OLD" (SYS_OP_C2C("REGISTER_NO")) 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "USERS" ;
--------------------------------------------------------
--  DDL for Index OWNER_INDEX7
--------------------------------------------------------

  CREATE INDEX "VRS"."OWNER_INDEX7" ON "VRS"."OWNER" ("OLD_DEVISION_UNIT_ID") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "USERS" ;
--------------------------------------------------------
--  DDL for Index SERIES_IDX
--------------------------------------------------------

  CREATE INDEX "VRS"."SERIES_IDX" ON "VRS"."SERIES" ("PROVINCE_ID") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_INDEX" ;
--------------------------------------------------------
--  DDL for Index ESIGN_INDEX2
--------------------------------------------------------

  CREATE INDEX "VRS"."ESIGN_INDEX2" ON "VRS"."ESIGN" ("BORROWER_REGNUM") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "USERS" ;
--------------------------------------------------------
--  DDL for Index REG_VEHICLE_ARCHIVE_IDX2
--------------------------------------------------------

  CREATE INDEX "VRS"."REG_VEHICLE_ARCHIVE_IDX2" ON "VRS"."REG_VEHICLE_ARCHIVE" ("VEHICLE_ID", "INS_CREATED_BY", "PLATE_NO") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "USERS" ;
--------------------------------------------------------
--  DDL for Index ESIGN_INDEX5
--------------------------------------------------------

  CREATE INDEX "VRS"."ESIGN_INDEX5" ON "VRS"."ESIGN" ("IS_DELETED") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "USERS" ;
--------------------------------------------------------
--  DDL for Index IDX$$_0F610001
--------------------------------------------------------

  CREATE INDEX "VRS"."IDX$$_0F610001" ON "VRS"."SERIES_INTERVAL" ("IS_ORDER") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "USERS" ;
--------------------------------------------------------
--  DDL for Index REG_VEHICLE_ARCHIVE_IDX1
--------------------------------------------------------

  CREATE INDEX "VRS"."REG_VEHICLE_ARCHIVE_IDX1" ON "VRS"."REG_VEHICLE_ARCHIVE" ("CERTIFICATE_NO") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_INDEX" ;
--------------------------------------------------------
--  DDL for Index ESIGN_INDEX4
--------------------------------------------------------

  CREATE INDEX "VRS"."ESIGN_INDEX4" ON "VRS"."ESIGN" ("NEW_OWNER_REGNUM") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "USERS" ;
--------------------------------------------------------
--  DDL for Index SERIES_NUMBER_WHERE1
--------------------------------------------------------

  CREATE INDEX "VRS"."SERIES_NUMBER_WHERE1" ON "VRS"."SERIES_NUMBER" ("IS_LOCAL", "IS_HIDDEN", "IS_OPENED") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_INDEX" ;
--------------------------------------------------------
--  DDL for Index ADDRESS_SUBDEV_IDX
--------------------------------------------------------

  CREATE INDEX "VRS"."ADDRESS_SUBDEV_IDX" ON "VRS"."ADDRESS_SUBDEV_OLD" ("PROVINCE_ID") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "USERS" ;
--------------------------------------------------------
--  DDL for Index OWNER_IDX3
--------------------------------------------------------

  CREATE INDEX "VRS"."OWNER_IDX3" ON "VRS"."OWNER_OLD" ("UPDATE_DATE", "TYPE_ID", "COUNTRY_ID", "PROVINCE_ID", "DISTRICT_ID", "DEVISION_UNIT_ID", "MICRO_DISTRICT_ID", "ORDER_QTY") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_INDEX" ;
--------------------------------------------------------
--  DDL for Index SERIES_NUMBER_WHERE
--------------------------------------------------------

  CREATE INDEX "VRS"."SERIES_NUMBER_WHERE" ON "VRS"."SERIES_NUMBER" ("IS_ORDER", "IS_GIVEN") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_INDEX" ;
--------------------------------------------------------
--  DDL for Index REF_ENGINE_MODEL_IDX
--------------------------------------------------------

  CREATE INDEX "VRS"."REF_ENGINE_MODEL_IDX" ON "VRS"."REF_ENGINE_MODEL" ("MARK_ID", "FUEL_TYPE_ID", "ECO_CLASS_ID") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_INDEX" ;
--------------------------------------------------------
--  DDL for Index SYSTEM_USER_WHERE
--------------------------------------------------------

  CREATE INDEX "VRS"."SYSTEM_USER_WHERE" ON "VRS"."SYSTEM_USER" ("USERDEPARTMENTID", "USERNAME", "PASSWORD") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "USERS" ;
--------------------------------------------------------
--  DDL for Index IDX_OWNER_STATUS_NVL
--------------------------------------------------------

  CREATE INDEX "VRS"."IDX_OWNER_STATUS_NVL" ON "VRS"."OWNER" (NVL("STATUS",(-1))) 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "USERS" ;
--------------------------------------------------------
--  DDL for Index OWNER_INDEX5
--------------------------------------------------------

  CREATE INDEX "VRS"."OWNER_INDEX5" ON "VRS"."OWNER" ("OLD_PROVINCE_ID") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "USERS" ;
--------------------------------------------------------
--  DDL for Index OWNER_INDEX6
--------------------------------------------------------

  CREATE INDEX "VRS"."OWNER_INDEX6" ON "VRS"."OWNER" ("OLD_DISTRICT_ID") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "USERS" ;
--------------------------------------------------------
--  DDL for Index REG_VEHICLE_OWNERSHIP_IDX3
--------------------------------------------------------

  CREATE INDEX "VRS"."REG_VEHICLE_OWNERSHIP_IDX3" ON "VRS"."REG_VEHICLE_OWNERSHIP" ("OWNER_ID", "VEHICLE_ID") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "USERS" ;
--------------------------------------------------------
--  DDL for Index REG_RFID_TAG_INDEX1
--------------------------------------------------------

  CREATE INDEX "VRS"."REG_RFID_TAG_INDEX1" ON "VRS"."REG_RFID_TAG" ("VEHICLE_ID") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "USERS" ;
--------------------------------------------------------
--  DDL for Index SERIES_INTERVAL_INDEX1
--------------------------------------------------------

  CREATE INDEX "VRS"."SERIES_INTERVAL_INDEX1" ON "VRS"."SERIES_INTERVAL" ("NAME", "SERIES_ID") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_INDEX" ;
--------------------------------------------------------
--  DDL for Index OWNER_IDX1
--------------------------------------------------------

  CREATE INDEX "VRS"."OWNER_IDX1" ON "VRS"."OWNER_OLD" ("REGISTER_NO") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_INDEX" ;
--------------------------------------------------------
--  DDL for Index SERIES_NUMBER_JOIN
--------------------------------------------------------

  CREATE INDEX "VRS"."SERIES_NUMBER_JOIN" ON "VRS"."SERIES_NUMBER" ("SERIES_ID") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_INDEX" ;
--------------------------------------------------------
--  DDL for Index REG_VEHICLE_UIDX
--------------------------------------------------------

  CREATE UNIQUE INDEX "VRS"."REG_VEHICLE_UIDX" ON "VRS"."REG_VEHICLE" ("CABIN_NO") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_INDEX" ;
--------------------------------------------------------
--  DDL for Index OWNER_INDEX8
--------------------------------------------------------

  CREATE INDEX "VRS"."OWNER_INDEX8" ON "VRS"."OWNER" ("COUNTRY_ID") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "USERS" ;
--------------------------------------------------------
--  DDL for Index ADDRESS_MICRODISTRICT_IDX
--------------------------------------------------------

  CREATE INDEX "VRS"."ADDRESS_MICRODISTRICT_IDX" ON "VRS"."ADDRESS_MICRODISTRICT" ("DEVISION_UNIT_ID") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "USERS" ;
--------------------------------------------------------
--  DDL for Index OWNER_IDX
--------------------------------------------------------

  CREATE UNIQUE INDEX "VRS"."OWNER_IDX" ON "VRS"."OWNER_OLD" ("ID") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_INDEX" ;
--------------------------------------------------------
--  DDL for Index SERIES_INTERVAL_INDEX2
--------------------------------------------------------

  CREATE INDEX "VRS"."SERIES_INTERVAL_INDEX2" ON "VRS"."SERIES_INTERVAL" ("IS_OPENED", "IS_HIDDEN") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "USERS" ;
--------------------------------------------------------
--  DDL for Index IDX$$_00010006
--------------------------------------------------------

  CREATE INDEX "VRS"."IDX$$_00010006" ON "VRS"."SERIES_NUMBER" ("NO", "TYPE", "IS_HIDDEN", "IS_LOCAL", "IS_OPENED", "ISAUCTION") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "USERS" ;
--------------------------------------------------------
--  DDL for Index SYSTEM_PLATE_FACTORY_IDX
--------------------------------------------------------

  CREATE INDEX "VRS"."SYSTEM_PLATE_FACTORY_IDX" ON "VRS"."SYSTEM_PLATE_FACTORY" ("PLATE_NO") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "USERS" ;
--------------------------------------------------------
--  DDL for Index SYSTEM_USER_MENU_WHERE
--------------------------------------------------------

  CREATE INDEX "VRS"."SYSTEM_USER_MENU_WHERE" ON "VRS"."SYSTEM_USER_MENU" ("ID", "ACTION_ID", "POSITION_ID", "TYPE_ID") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "USERS" ;
--------------------------------------------------------
--  DDL for Index SERIES_NUMBER_ORDER
--------------------------------------------------------

  CREATE INDEX "VRS"."SERIES_NUMBER_ORDER" ON "VRS"."SERIES_NUMBER" ("NAME") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_INDEX" ;
--------------------------------------------------------
--  DDL for Index REG_VEHICLE_OWNER
--------------------------------------------------------

  CREATE INDEX "VRS"."REG_VEHICLE_OWNER" ON "VRS"."REG_VEHICLE" ("OWNER_ID") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "USERS" ;
--------------------------------------------------------
--  DDL for Index OWNER_INDEX3
--------------------------------------------------------

  CREATE INDEX "VRS"."OWNER_INDEX3" ON "VRS"."OWNER" ("TYPE_ID") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "USERS" ;
--------------------------------------------------------
--  DDL for Index LOG_UPDATED_IDX
--------------------------------------------------------

  CREATE INDEX "VRS"."LOG_UPDATED_IDX" ON "VRS"."LOG_UPDATED" ("UPDATED_DATE") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "USERS" ;
--------------------------------------------------------
--  DDL for Index OWNER_IDX2
--------------------------------------------------------

  CREATE INDEX "VRS"."OWNER_IDX2" ON "VRS"."OWNER_OLD" ("CELLPHONE", "WORKPHONE", "HOMEPHONE") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_INDEX" ;
--------------------------------------------------------
--  DDL for Index REG_MODEL_IDX
--------------------------------------------------------

  CREATE INDEX "VRS"."REG_MODEL_IDX" ON "VRS"."REG_MODEL" ("MARK_ID") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_INDEX" ;
--------------------------------------------------------
--  DDL for Index REG_MODIPICACE_IDX
--------------------------------------------------------

  CREATE INDEX "VRS"."REG_MODIPICACE_IDX" ON "VRS"."REG_MODIPICACE" ("MODEL_ID", "VEHICLE_TYPE_ID", "CLASSIFICATION_ID", "ENGINE_MODEL_ID", "IS_HYBRID") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_INDEX" ;
--------------------------------------------------------
--  DDL for Index REG_VEHICLE_OWNERSHIP_IDX1
--------------------------------------------------------

  CREATE INDEX "VRS"."REG_VEHICLE_OWNERSHIP_IDX1" ON "VRS"."REG_VEHICLE_OWNERSHIP" ("END_DATE") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "USERS" ;
--------------------------------------------------------
--  DDL for Index SERIES_NUMBER_VEH_ID
--------------------------------------------------------

  CREATE INDEX "VRS"."SERIES_NUMBER_VEH_ID" ON "VRS"."SERIES_NUMBER" ("VEHICLE_ID") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "USERS" ;
--------------------------------------------------------
--  DDL for Index REG_VEHICLE_WHERE
--------------------------------------------------------

  CREATE INDEX "VRS"."REG_VEHICLE_WHERE" ON "VRS"."REG_VEHICLE" ("PLATE_NO") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "USERS" ;
--------------------------------------------------------
--  DDL for Index REG_VEHICLE_OWNERSHIP_IDX
--------------------------------------------------------

  CREATE UNIQUE INDEX "VRS"."REG_VEHICLE_OWNERSHIP_IDX" ON "VRS"."REG_VEHICLE_OWNERSHIP" ("ID") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_DATA" ;
--------------------------------------------------------
--  DDL for Index REG_VEHICLE_INSP_ARCHIVE_IDX
--------------------------------------------------------

  CREATE INDEX "VRS"."REG_VEHICLE_INSP_ARCHIVE_IDX" ON "VRS"."REG_VEHICLE_INSP_ARCHIVE" ("VEHICLE_ID", "SERVICE_ID", "CREATED_DATE") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_INDEX" ;
--------------------------------------------------------
--  DDL for Index REG_CERTIFICATE_IDX
--------------------------------------------------------

  CREATE INDEX "VRS"."REG_CERTIFICATE_IDX" ON "VRS"."REG_CERTIFICATE" ("USER_ID", "VEHICLE_ID", "SERVICE_ID") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_INDEX" ;
--------------------------------------------------------
--  DDL for Index AUDITS_INDEX1
--------------------------------------------------------

  CREATE INDEX "VRS"."AUDITS_INDEX1" ON "VRS"."AUDITS" ("ID") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_INDEX" ;
--------------------------------------------------------
--  DDL for Trigger ADDRESS_MICRODISTRICT_TRG
--------------------------------------------------------

  CREATE OR REPLACE EDITIONABLE TRIGGER "VRS"."ADDRESS_MICRODISTRICT_TRG" 
BEFORE INSERT ON ADDRESS_MICRODISTRICT 
FOR EACH ROW 
BEGIN
  <<COLUMN_SEQUENCES>>
  BEGIN
    IF INSERTING AND :NEW.ID IS NULL THEN
      SELECT ADDRESS_MICRODISTRICT_SEQ.NEXTVAL INTO :NEW.ID FROM SYS.DUAL;
    END IF;
  END COLUMN_SEQUENCES;
END;







/
ALTER TRIGGER "VRS"."ADDRESS_MICRODISTRICT_TRG" DISABLE;
--------------------------------------------------------
--  DDL for Trigger ADDRESS_MICRODISTRICT_TRG_UI
--------------------------------------------------------

  CREATE OR REPLACE EDITIONABLE TRIGGER "VRS"."ADDRESS_MICRODISTRICT_TRG_UI" 
AFTER DELETE OR INSERT OR UPDATE ON VRS.ADDRESS_MICRODISTRICT 
FOR EACH ROW 
DECLARE
    VALJSON PLJSON;
    VALCLOB CLOB;
    P_RECORD_ID NUMBER;
    P_LOG_TYPE NUMBER;
BEGIN
  DBMS_LOB.CREATETEMPORARY(VALCLOB, TRUE);
  VALJSON:=PLJSON();
  
  P_RECORD_ID:=:NEW.ID;
  IF(INSERTING) THEN
    P_LOG_TYPE:=1;
  ELSIF(UPDATING) THEN
    P_LOG_TYPE:=2;
  ELSIF(DELETING) THEN
    P_LOG_TYPE:=3;
    P_RECORD_ID:=:OLD.ID;
  END IF;
IF(INSERTING OR UPDATING) THEN
  VALJSON.PUT('ID',:NEW.ID);
  VALJSON.PUT('CODE',:NEW.CODE);
  VALJSON.PUT('NAME',:NEW.NAME);
  VALJSON.PUT('DEVISION_UNIT_ID',:NEW.DEVISION_UNIT_ID);
  VALJSON.PUT('CREATED_BY_ID',:NEW.CREATED_BY_ID);
  VALJSON.PUT('UPDATED_BY_ID',:NEW.UPDATED_BY_ID);
  VALJSON.PUT('CREATE_DATE',:NEW.CREATE_DATE);
  VALJSON.PUT('UPDATE_DATE',:NEW.UPDATE_DATE);   
END IF;
IF(UPDATING OR DELETING) THEN
  VALJSON.PUT('ID',:OLD.ID);
  VALJSON.PUT('CODE',:OLD.CODE);
  VALJSON.PUT('NAME',:OLD.NAME);
  VALJSON.PUT('DEVISION_UNIT_ID',:OLD.DEVISION_UNIT_ID);
  VALJSON.PUT('CREATED_BY_ID',:OLD.CREATED_BY_ID);
  VALJSON.PUT('UPDATED_BY_ID',:OLD.UPDATED_BY_ID);
  VALJSON.PUT('CREATE_DATE',:OLD.CREATE_DATE);
  VALJSON.PUT('UPDATE_DATE',:OLD.UPDATE_DATE);   
END IF;
  VALJSON.TO_CLOB(VALCLOB,FALSE,0,TRUE);
  INSERT INTO USER_LOG.LOG_ACTIONS_VRS (
    ID,
    LOG_DATE,
    LOG_TYPE,
    TABLE_NAME,
    JSON_VAL,
    STATUS,
    ACTION_TYPE,
    RECORD_ID
    ) VALUES (
        USER_LOG.SEQ_LOG_ACTIONS_VRS.NEXTVAL,
        SYSDATE,
        P_LOG_TYPE,
        'ADDRESS_MICRODISTRICT',
        VALCLOB,
        1,
        2,
        P_RECORD_ID
    );
END;
/
ALTER TRIGGER "VRS"."ADDRESS_MICRODISTRICT_TRG_UI" DISABLE;
--------------------------------------------------------
--  DDL for Trigger ADDRESS_SUBDEV_UNIT_TRG
--------------------------------------------------------

  CREATE OR REPLACE EDITIONABLE TRIGGER "VRS"."ADDRESS_SUBDEV_UNIT_TRG" 
BEFORE INSERT ON "VRS"."ADDRESS_SUBDEV_UNIT_OLD" 
FOR EACH ROW 
BEGIN
  <<COLUMN_SEQUENCES>>
  BEGIN
    IF INSERTING AND :NEW.ID IS NULL THEN
      SELECT ADDRESS_SUBDEV_UNIT_SEQ.NEXTVAL INTO :NEW.ID FROM SYS.DUAL;
    END IF;
  END COLUMN_SEQUENCES;
END;



/
ALTER TRIGGER "VRS"."ADDRESS_SUBDEV_UNIT_TRG" DISABLE;
--------------------------------------------------------
--  DDL for Trigger ADDRESS_SUBDEV_UNIT_TRG_UI
--------------------------------------------------------

  CREATE OR REPLACE EDITIONABLE TRIGGER "VRS"."ADDRESS_SUBDEV_UNIT_TRG_UI" 
AFTER DELETE OR INSERT OR UPDATE ON "VRS"."ADDRESS_SUBDEV_UNIT_OLD" 
FOR EACH ROW 
DECLARE
    VALJSON PLJSON;
    VALCLOB CLOB;
    P_RECORD_ID NUMBER;
    P_LOG_TYPE NUMBER;
BEGIN
  DBMS_LOB.CREATETEMPORARY(VALCLOB, TRUE);
  VALJSON:=PLJSON();
  
  P_RECORD_ID:=:NEW.ID;
  IF(INSERTING) THEN
    P_LOG_TYPE:=1;
  ELSIF(UPDATING) THEN
    P_LOG_TYPE:=2;
  ELSIF(DELETING) THEN
    P_LOG_TYPE:=3;
    P_RECORD_ID:=:OLD.ID;
  END IF;
IF(INSERTING OR UPDATING) THEN
  VALJSON.PUT('ID',:NEW.ID);
  VALJSON.PUT('CREATE_DATE',:NEW.CREATE_DATE);
  VALJSON.PUT('NAME',:NEW.NAME);
  VALJSON.PUT('UPDATE_DATE',:NEW.UPDATE_DATE);
  VALJSON.PUT('CREATED_BY_ID',:NEW.CREATED_BY_ID);
  VALJSON.PUT('UPDATED_BY_ID',:NEW.UPDATED_BY_ID);
  VALJSON.PUT('DEVISION_ID',:NEW.DEVISION_ID);
END IF;
IF(UPDATING OR DELETING) THEN
  VALJSON.PUT('ID',:OLD.ID);
  VALJSON.PUT('CREATE_DATE',:OLD.CREATE_DATE);
  VALJSON.PUT('NAME',:OLD.NAME);
  VALJSON.PUT('UPDATE_DATE',:OLD.UPDATE_DATE);
  VALJSON.PUT('CREATED_BY_ID',:OLD.CREATED_BY_ID);
  VALJSON.PUT('UPDATED_BY_ID',:OLD.UPDATED_BY_ID);
  VALJSON.PUT('DEVISION_ID',:OLD.DEVISION_ID);
END IF;
  VALJSON.TO_CLOB(VALCLOB,FALSE,0,TRUE);
  INSERT INTO USER_LOG.LOG_ACTIONS_VRS (
    ID,
    LOG_DATE,
    LOG_TYPE,
    TABLE_NAME,
    JSON_VAL,
    STATUS,
    ACTION_TYPE,
    RECORD_ID
    ) VALUES (
        USER_LOG.SEQ_LOG_ACTIONS_VRS.NEXTVAL,
        SYSDATE,
        P_LOG_TYPE,
        'ADDRESS_SUBDEV_UNIT',
        VALCLOB,
        1,
        2,
        P_RECORD_ID
    );
END;
/
ALTER TRIGGER "VRS"."ADDRESS_SUBDEV_UNIT_TRG_UI" DISABLE;
--------------------------------------------------------
--  DDL for Trigger ARCHIVE_NUMBER_TRG
--------------------------------------------------------

  CREATE OR REPLACE EDITIONABLE TRIGGER "VRS"."ARCHIVE_NUMBER_TRG" 
BEFORE INSERT ON ARCHIVE_NUMBER 
FOR EACH ROW 
BEGIN
  <<COLUMN_SEQUENCES>>
  BEGIN
    IF INSERTING AND :NEW.ID IS NULL THEN
      SELECT ARCHIVE_NUMBER_SEQ.NEXTVAL INTO :NEW.ID FROM SYS.DUAL;
    END IF;
  END COLUMN_SEQUENCES;
END;







/
ALTER TRIGGER "VRS"."ARCHIVE_NUMBER_TRG" ENABLE;
--------------------------------------------------------
--  DDL for Trigger EPAY_TRANSACTION_TRG
--------------------------------------------------------

  CREATE OR REPLACE EDITIONABLE TRIGGER "VRS"."EPAY_TRANSACTION_TRG" 
BEFORE INSERT ON VRS.EPAY_TRANSACTION 
FOR EACH ROW 
BEGIN
  <<COLUMN_SEQUENCES>>
  BEGIN
    IF INSERTING AND :NEW.ID IS NULL THEN
      SELECT EPAY_TRANSACTION_SEQ.NEXTVAL INTO :NEW.ID FROM SYS.DUAL;
    END IF;
  END COLUMN_SEQUENCES;
END;

/
ALTER TRIGGER "VRS"."EPAY_TRANSACTION_TRG" ENABLE;
--------------------------------------------------------
--  DDL for Trigger LOG_UPDATED_TRG
--------------------------------------------------------

  CREATE OR REPLACE EDITIONABLE TRIGGER "VRS"."LOG_UPDATED_TRG" 
BEFORE INSERT ON VRS.LOG_UPDATED 
FOR EACH ROW 
BEGIN
  <<COLUMN_SEQUENCES>>
  BEGIN
    NULL;
  END COLUMN_SEQUENCES;
END;

/
ALTER TRIGGER "VRS"."LOG_UPDATED_TRG" ENABLE;
--------------------------------------------------------
--  DDL for Trigger OWNER_TRG
--------------------------------------------------------

  CREATE OR REPLACE EDITIONABLE TRIGGER "VRS"."OWNER_TRG" 
BEFORE INSERT ON VRS.OWNER 
FOR EACH ROW 
BEGIN
  <<COLUMN_SEQUENCES>>
  BEGIN
    IF INSERTING AND :NEW.ID IS NULL THEN
      SELECT OWNER_SEQ.NEXTVAL INTO :NEW.ID FROM SYS.DUAL;
    END IF;
  END COLUMN_SEQUENCES;
END;
/
ALTER TRIGGER "VRS"."OWNER_TRG" ENABLE;
--------------------------------------------------------
--  DDL for Trigger OWNER_TRG_IU
--------------------------------------------------------

  CREATE OR REPLACE EDITIONABLE TRIGGER "VRS"."OWNER_TRG_IU" 
AFTER INSERT OR UPDATE OR DELETE ON "VRS"."OWNER" 
--REGISTER_NO,TYPE_ID,LAST_NAME,FIRST_NAME,ADDRESS_DETAIL,HOMEPHONE,CELLPHONE,WORKPHONE ON VRS.OWNER 
FOR EACH ROW 
DECLARE
    VALJSON PLJSON;
    VALCLOB CLOB;
    P_RECORD_ID NUMBER;
    P_LOG_TYPE NUMBER;
BEGIN
--  BEGIN
--    IF INSERTING THEN
--        VRS.INSERT_LOG_UPDATED(:NEW.ID, 'I', 'OWNER');
--    ELSIF UPDATING THEN
--        VRS.INSERT_LOG_UPDATED(:OLD.ID, 'U', 'OWNER');
--    END IF;
--  END;

    IF :NEW.UPDATED_BY_ID IS NOT NULL THEN
      DBMS_LOB.CREATETEMPORARY(VALCLOB, TRUE);
      VALJSON:=PLJSON();
    
      P_RECORD_ID:=:NEW.ID;
      IF(INSERTING) THEN
        P_LOG_TYPE:=1;
      ELSIF(UPDATING) THEN
        P_LOG_TYPE:=2;
      ELSIF(DELETING) THEN
        P_LOG_TYPE:=3;
        P_RECORD_ID:=:OLD.ID;
      END IF;
    IF(INSERTING OR UPDATING) THEN
      VALJSON.PUT('ID',:NEW.ID);
      VALJSON.PUT('CREATE_DATE',:NEW.CREATE_DATE);
      VALJSON.PUT('CREATED_BY_ID',:NEW.CREATED_BY_ID);
      VALJSON.PUT('REGISTER_NO',:NEW.REGISTER_NO);
      VALJSON.PUT('TYPE_ID',:NEW.TYPE_ID);
      VALJSON.PUT('FAMILY_NAME',:NEW.FAMILY_NAME);
      VALJSON.PUT('LAST_NAME',:NEW.LAST_NAME);
      VALJSON.PUT('FIRST_NAME',:NEW.FIRST_NAME);
      VALJSON.PUT('COUNTRY_ID',:NEW.COUNTRY_ID);
      --VALJSON.PUT('PROVINCE_ID',:NEW.PROVINCE_ID);
      --VALJSON.PUT('DISTRICT_ID',:NEW.DISTRICT_ID);
      VALJSON.PUT('DEVISION_UNIT_ID',:NEW.DEVISION_UNIT_ID);
      --VALJSON.PUT('MICRO_DISTRICT_ID',:NEW.MICRO_DISTRICT_ID);
      --VALJSON.PUT('STREET',:NEW.STREET);
      --VALJSON.PUT('APARTMENT_NO',:NEW.APARTMENT_NO);
      --VALJSON.PUT('DOOR_NO',:NEW.DOOR_NO);
      VALJSON.PUT('ADDRESS_DETAIL',:NEW.ADDRESS_DETAIL);
      VALJSON.PUT('HOMEPHONE',:NEW.HOMEPHONE);
      VALJSON.PUT('WORKPHONE',:NEW.WORKPHONE);
      VALJSON.PUT('CELLPHONE',:NEW.CELLPHONE);
      VALJSON.PUT('GENDER',:NEW.GENDER);
      VALJSON.PUT('UPDATE_DATE',:NEW.UPDATE_DATE);
      VALJSON.PUT('UPDATED_BY_ID',:NEW.UPDATED_BY_ID);
      VALJSON.PUT('CIVIL_ID',:NEW.CIVIL_ID);
      --VALJSON.PUT('MORE_INFO',:NEW.MORE_INFO);
      VALJSON.PUT('ORDER_QTY',:NEW.ORDER_QTY);
      VALJSON.PUT('STATUS',:NEW.STATUS);
    END IF;
    IF(UPDATING OR DELETING) THEN
      VALJSON.PUT('ID',:OLD.ID);
      VALJSON.PUT('CREATE_DATE',:OLD.CREATE_DATE);
      VALJSON.PUT('CREATED_BY_ID',:OLD.CREATED_BY_ID);
      VALJSON.PUT('REGISTER_NO',:OLD.REGISTER_NO);
      VALJSON.PUT('TYPE_ID',:OLD.TYPE_ID);
      VALJSON.PUT('FAMILY_NAME',:OLD.FAMILY_NAME);
      VALJSON.PUT('LAST_NAME',:OLD.LAST_NAME);
      VALJSON.PUT('FIRST_NAME',:OLD.FIRST_NAME);
      VALJSON.PUT('COUNTRY_ID',:OLD.COUNTRY_ID);
      --VALJSON.PUT('PROVINCE_ID',:OLD.PROVINCE_ID);
      --VALJSON.PUT('DISTRICT_ID',:OLD.DISTRICT_ID);
      VALJSON.PUT('DEVISION_UNIT_ID',:OLD.DEVISION_UNIT_ID);
      --VALJSON.PUT('MICRO_DISTRICT_ID',:OLD.MICRO_DISTRICT_ID);
      --VALJSON.PUT('STREET',:OLD.STREET);
      --VALJSON.PUT('APARTMENT_NO',:OLD.APARTMENT_NO);
      --VALJSON.PUT('DOOR_NO',:OLD.DOOR_NO);
      VALJSON.PUT('ADDRESS_DETAIL',:OLD.ADDRESS_DETAIL);
      VALJSON.PUT('HOMEPHONE',:OLD.HOMEPHONE);
      VALJSON.PUT('WORKPHONE',:OLD.WORKPHONE);
      VALJSON.PUT('CELLPHONE',:OLD.CELLPHONE);
      VALJSON.PUT('GENDER',:OLD.GENDER);
      VALJSON.PUT('UPDATE_DATE',:OLD.UPDATE_DATE);
      VALJSON.PUT('UPDATED_BY_ID',:OLD.UPDATED_BY_ID);
      VALJSON.PUT('CIVIL_ID',:OLD.CIVIL_ID);
      --VALJSON.PUT('MORE_INFO',:OLD.MORE_INFO);
      VALJSON.PUT('ORDER_QTY',:OLD.ORDER_QTY);
      VALJSON.PUT('STATUS',:OLD.STATUS);
    END IF;
      VALJSON.TO_CLOB(VALCLOB,FALSE,0,TRUE);
      INSERT INTO USER_LOG.LOG_ACTIONS_VRS (
        ID,
        LOG_DATE,
        LOG_TYPE,
        TABLE_NAME,
        JSON_VAL,
        STATUS,
        ACTION_TYPE,
        RECORD_ID
        ) VALUES (
            USER_LOG.SEQ_LOG_ACTIONS_VRS.NEXTVAL,
            SYSDATE,
            P_LOG_TYPE,
            'OWNER',
            VALCLOB,
            1,
            2,
            P_RECORD_ID
        );
    END IF;
END;
/
ALTER TRIGGER "VRS"."OWNER_TRG_IU" ENABLE;
--------------------------------------------------------
--  DDL for Trigger REF_REFERENCE_ORG_TRG
--------------------------------------------------------

  CREATE OR REPLACE EDITIONABLE TRIGGER "VRS"."REF_REFERENCE_ORG_TRG" 
BEFORE INSERT ON VRS.REF_REFERENCE_ORG 
FOR EACH ROW 
BEGIN
  <<COLUMN_SEQUENCES>>
  BEGIN
    IF INSERTING AND :NEW.ID IS NULL THEN
      SELECT REF_REFERENCE_ORG_SEQ.NEXTVAL INTO :NEW.ID FROM SYS.DUAL;
    END IF;
  END COLUMN_SEQUENCES;
END;




/
ALTER TRIGGER "VRS"."REF_REFERENCE_ORG_TRG" ENABLE;
--------------------------------------------------------
--  DDL for Trigger REG_CERTIFICATE_TRG
--------------------------------------------------------

  CREATE OR REPLACE EDITIONABLE TRIGGER "VRS"."REG_CERTIFICATE_TRG" 
BEFORE INSERT ON VRS.REG_CERTIFICATE 
FOR EACH ROW 
BEGIN
  <<COLUMN_SEQUENCES>>
  BEGIN
    IF INSERTING AND :NEW.ID IS NULL THEN
      SELECT REG_CERTIFICATE_SEQ.NEXTVAL INTO :NEW.ID FROM SYS.DUAL;
    END IF;
  END COLUMN_SEQUENCES;
END;

/
ALTER TRIGGER "VRS"."REG_CERTIFICATE_TRG" ENABLE;
--------------------------------------------------------
--  DDL for Trigger REG_LIMITED_TRG
--------------------------------------------------------

  CREATE OR REPLACE EDITIONABLE TRIGGER "VRS"."REG_LIMITED_TRG" 
BEFORE INSERT ON REG_LIMITED 
FOR EACH ROW 
BEGIN
  <<COLUMN_SEQUENCES>>
  BEGIN
    IF INSERTING AND :NEW.ID IS NULL THEN
      SELECT REG_LIMITED_SEQ.NEXTVAL INTO :NEW.ID FROM SYS.DUAL;
    END IF;
  END COLUMN_SEQUENCES;
END;





/
ALTER TRIGGER "VRS"."REG_LIMITED_TRG" ENABLE;
--------------------------------------------------------
--  DDL for Trigger REG_MARK_TRG
--------------------------------------------------------

  CREATE OR REPLACE EDITIONABLE TRIGGER "VRS"."REG_MARK_TRG" 
BEFORE INSERT ON REG_MARK 
FOR EACH ROW 
BEGIN
  <<COLUMN_SEQUENCES>>
  BEGIN
    IF INSERTING AND :NEW.ID IS NULL THEN
      SELECT REG_MARK_SEQ.NEXTVAL INTO :NEW.ID FROM SYS.DUAL;
    END IF;
  END COLUMN_SEQUENCES;
END;







/
ALTER TRIGGER "VRS"."REG_MARK_TRG" ENABLE;
--------------------------------------------------------
--  DDL for Trigger REG_PLATENUMBER_SAVE_ORDER_TRG
--------------------------------------------------------

  CREATE OR REPLACE EDITIONABLE TRIGGER "VRS"."REG_PLATENUMBER_SAVE_ORDER_TRG" 
BEFORE INSERT ON VRS.REG_PLATENUMBER_SAVE_ORDER 
FOR EACH ROW 
BEGIN
  <<COLUMN_SEQUENCES>>
  BEGIN
    IF INSERTING AND :NEW.ID IS NULL THEN
      SELECT REG_PLATENUMBER_SAVE_ORDER_SEQ.NEXTVAL INTO :NEW.ID FROM SYS.DUAL;
    END IF;
  END COLUMN_SEQUENCES;
END;

/
ALTER TRIGGER "VRS"."REG_PLATENUMBER_SAVE_ORDER_TRG" ENABLE;
--------------------------------------------------------
--  DDL for Trigger REG_REFERENCE_LOG_TRG
--------------------------------------------------------

  CREATE OR REPLACE EDITIONABLE TRIGGER "VRS"."REG_REFERENCE_LOG_TRG" 
BEFORE INSERT ON VRS.REG_REFERENCE_LOG 
FOR EACH ROW 
BEGIN
  <<COLUMN_SEQUENCES>>
  BEGIN
    IF INSERTING AND :NEW.ID IS NULL THEN
      SELECT REG_REFERENCE_LOG_SEQ.NEXTVAL INTO :NEW.ID FROM SYS.DUAL;
    END IF;
  END COLUMN_SEQUENCES;
END;



/
ALTER TRIGGER "VRS"."REG_REFERENCE_LOG_TRG" ENABLE;
--------------------------------------------------------
--  DDL for Trigger REG_RFID_TAG_TRG
--------------------------------------------------------

  CREATE OR REPLACE EDITIONABLE TRIGGER "VRS"."REG_RFID_TAG_TRG" 
BEFORE INSERT ON VRS.REG_RFID_TAG 
FOR EACH ROW 
BEGIN
  <<COLUMN_SEQUENCES>>
  BEGIN
    IF INSERTING AND :NEW.PHONE_NUMBER IS NULL THEN
      SELECT REG_RFID_TAG_SEQ.NEXTVAL INTO :NEW.PHONE_NUMBER FROM SYS.DUAL;
    END IF;
  END COLUMN_SEQUENCES;
END;

/
ALTER TRIGGER "VRS"."REG_RFID_TAG_TRG" ENABLE;
--------------------------------------------------------
--  DDL for Trigger REG_STATUS_TRG
--------------------------------------------------------

  CREATE OR REPLACE EDITIONABLE TRIGGER "VRS"."REG_STATUS_TRG" 
BEFORE INSERT ON REG_STATUS 
FOR EACH ROW 
BEGIN
  <<COLUMN_SEQUENCES>>
  BEGIN
    NULL;
  END COLUMN_SEQUENCES;
END;







/
ALTER TRIGGER "VRS"."REG_STATUS_TRG" ENABLE;
--------------------------------------------------------
--  DDL for Trigger REG_VEHICLE_ARCHIVE_ID_ATR
--------------------------------------------------------

  CREATE OR REPLACE EDITIONABLE TRIGGER "VRS"."REG_VEHICLE_ARCHIVE_ID_ATR" 
BEFORE INSERT ON VRS."REG_VEHICLE_ARCHIVE" 
FOR EACH ROW 
DECLARE 
MAX_ID NUMBER; 
CUR_SEQ NUMBER; 
BEGIN 
IF :NEW."ID" IS NULL THEN 
SELECT VRS."REG_VEHICLE_ARCHIVE_ID_ASQ".NEXTVAL INTO :NEW."ID" FROM DUAL; 
ELSE 
SELECT GREATEST(MAX("ID"), :NEW."ID") INTO MAX_ID FROM "REG_VEHICLE_ARCHIVE"; 
SELECT VRS."REG_VEHICLE_ARCHIVE_ID_ASQ".NEXTVAL INTO CUR_SEQ FROM DUAL; 
WHILE CUR_SEQ < MAX_ID 
LOOP 
SELECT VRS."REG_VEHICLE_ARCHIVE_ID_ASQ".NEXTVAL INTO CUR_SEQ FROM DUAL; 
END LOOP; 
END IF; 
END;






/
ALTER TRIGGER "VRS"."REG_VEHICLE_ARCHIVE_ID_ATR" ENABLE;
--------------------------------------------------------
--  DDL for Trigger REG_VEHICLE_ARCHIVE_TRG
--------------------------------------------------------

  CREATE OR REPLACE EDITIONABLE TRIGGER "VRS"."REG_VEHICLE_ARCHIVE_TRG" 
BEFORE INSERT ON VRS.REG_VEHICLE_ARCHIVE 
FOR EACH ROW 
BEGIN
  <<COLUMN_SEQUENCES>>
  BEGIN
    IF INSERTING AND :NEW.ID IS NULL THEN
      SELECT REG_VEHICLE_ARCHIVE_SEQ.NEXTVAL INTO :NEW.ID FROM SYS.DUAL;
    END IF;
  END COLUMN_SEQUENCES;
END;



/
ALTER TRIGGER "VRS"."REG_VEHICLE_ARCHIVE_TRG" ENABLE;
--------------------------------------------------------
--  DDL for Trigger REG_VEHICLE_INSP_ARCHIVE_TRG
--------------------------------------------------------

  CREATE OR REPLACE EDITIONABLE TRIGGER "VRS"."REG_VEHICLE_INSP_ARCHIVE_TRG" 
BEFORE INSERT ON "VRS"."REG_VEHICLE_INSP_ARCHIVE" 
FOR EACH ROW 
BEGIN
  <<COLUMN_SEQUENCES>>
  BEGIN
    IF INSERTING AND :NEW.ID IS NULL THEN
      SELECT SEQ_REG_VEHICLE_INSP_ARCHIVE.NEXTVAL INTO :NEW.ID FROM SYS.DUAL;
    END IF;
  END COLUMN_SEQUENCES;
END;

/
ALTER TRIGGER "VRS"."REG_VEHICLE_INSP_ARCHIVE_TRG" ENABLE;
--------------------------------------------------------
--  DDL for Trigger REG_VEHICLE_OWNERSHIP_TRG
--------------------------------------------------------

  CREATE OR REPLACE EDITIONABLE TRIGGER "VRS"."REG_VEHICLE_OWNERSHIP_TRG" 
BEFORE INSERT ON REG_VEHICLE_OWNERSHIP 
FOR EACH ROW 
BEGIN
  <<COLUMN_SEQUENCES>>
  BEGIN
    IF INSERTING AND :NEW.ID IS NULL THEN
      SELECT REG_VEHICLE_OWNERSHIP_SEQ.NEXTVAL INTO :NEW.ID FROM SYS.DUAL;
    END IF;
  END COLUMN_SEQUENCES;
END;





/
ALTER TRIGGER "VRS"."REG_VEHICLE_OWNERSHIP_TRG" ENABLE;
--------------------------------------------------------
--  DDL for Trigger SEQ_REG_MARK_INC
--------------------------------------------------------

  CREATE OR REPLACE EDITIONABLE TRIGGER "VRS"."SEQ_REG_MARK_INC" 
   before insert on "VRS"."REG_MARK" 
   for each row 
begin  
   if inserting then 
      if :NEW."NAME" is null then 
         select SEQ_REG_MARK.nextval into :NEW."NAME" from dual; 
      end if; 
   end if; 
end;







/
ALTER TRIGGER "VRS"."SEQ_REG_MARK_INC" ENABLE;
--------------------------------------------------------
--  DDL for Trigger SERIES_INTERVAL_TRG
--------------------------------------------------------

  CREATE OR REPLACE EDITIONABLE TRIGGER "VRS"."SERIES_INTERVAL_TRG" 
BEFORE INSERT ON SERIES_INTERVAL 
FOR EACH ROW 
BEGIN
  <<COLUMN_SEQUENCES>>
  BEGIN
    IF INSERTING AND :NEW.ID IS NULL THEN
      SELECT SERIES_INTERVAL_SEQ.NEXTVAL INTO :NEW.ID FROM SYS.DUAL;
    END IF;
  END COLUMN_SEQUENCES;
END;






/
ALTER TRIGGER "VRS"."SERIES_INTERVAL_TRG" ENABLE;
--------------------------------------------------------
--  DDL for Trigger SERIES_INTERVAL_TRG_UI
--------------------------------------------------------

  CREATE OR REPLACE EDITIONABLE TRIGGER "VRS"."SERIES_INTERVAL_TRG_UI" 
AFTER DELETE OR UPDATE ON VRS.SERIES_INTERVAL 
  FOR EACH ROW
DECLARE
    VALJSON PLJSON;
    VALCLOB CLOB;
    P_RECORD_ID NUMBER;
    P_LOG_TYPE NUMBER;
BEGIN
  DBMS_LOB.CREATETEMPORARY(VALCLOB, TRUE);
  VALJSON:=PLJSON();
  
  P_RECORD_ID:=:NEW.ID;
  IF(INSERTING) THEN
    P_LOG_TYPE:=1;
  ELSIF(UPDATING) THEN
    P_LOG_TYPE:=2;
  ELSIF(DELETING) THEN
    P_LOG_TYPE:=3;
    P_RECORD_ID:=:OLD.ID;
  END IF;
IF(INSERTING OR UPDATING) THEN
  VALJSON.PUT('ID',:NEW.ID);
  VALJSON.PUT('CREATE_DATE',:NEW.CREATE_DATE);
  VALJSON.PUT('NAME',:NEW.NAME);
  VALJSON.PUT('UPDATE_DATE',:NEW.UPDATE_DATE);
  VALJSON.PUT('CREATED_BY_ID',:NEW.CREATED_BY_ID);
  VALJSON.PUT('UPDATED_BY_ID',:NEW.UPDATED_BY_ID);
  VALJSON.PUT('FROM_NUMBER',:NEW.FROM_NUMBER);
  VALJSON.PUT('TO_NUMBER',:NEW.TO_NUMBER);
  VALJSON.PUT('LOCAL_USER_ID',:NEW.LOCAL_USER_ID);
  VALJSON.PUT('SERIES_ID',:NEW.SERIES_ID);
  VALJSON.PUT('IS_LOCAL',:NEW.IS_LOCAL);
  VALJSON.PUT('IS_ORDER',:NEW.IS_ORDER);
  VALJSON.PUT('IS_HIDDEN',:NEW.IS_HIDDEN);
  VALJSON.PUT('IS_OPENED',:NEW.IS_OPENED);
  VALJSON.PUT('IS_AUTO',:NEW.IS_AUTO);
  VALJSON.PUT('TYPE',:NEW.TYPE);
END IF;
IF(UPDATING OR DELETING) THEN
  VALJSON.PUT('ID',:OLD.ID);
  VALJSON.PUT('CREATE_DATE',:OLD.CREATE_DATE);
  VALJSON.PUT('NAME',:OLD.NAME);
  VALJSON.PUT('UPDATE_DATE',:OLD.UPDATE_DATE);
  VALJSON.PUT('CREATED_BY_ID',:OLD.CREATED_BY_ID);
  VALJSON.PUT('UPDATED_BY_ID',:OLD.UPDATED_BY_ID);
  VALJSON.PUT('FROM_NUMBER',:OLD.FROM_NUMBER);
  VALJSON.PUT('TO_NUMBER',:OLD.TO_NUMBER);
  VALJSON.PUT('LOCAL_USER_ID',:OLD.LOCAL_USER_ID);
  VALJSON.PUT('SERIES_ID',:OLD.SERIES_ID);
  VALJSON.PUT('IS_LOCAL',:OLD.IS_LOCAL);
  VALJSON.PUT('IS_ORDER',:OLD.IS_ORDER);
  VALJSON.PUT('IS_HIDDEN',:OLD.IS_HIDDEN);
  VALJSON.PUT('IS_OPENED',:OLD.IS_OPENED);
  VALJSON.PUT('IS_AUTO',:OLD.IS_AUTO);
  VALJSON.PUT('TYPE',:OLD.TYPE);
END IF;
  VALJSON.TO_CLOB(VALCLOB,FALSE,0,TRUE);
  INSERT INTO USER_LOG.LOG_ACTIONS_VRS (
    ID,
    LOG_DATE,
    LOG_TYPE,
    TABLE_NAME,
    JSON_VAL,
    STATUS,
    ACTION_TYPE,
    RECORD_ID
    ) VALUES (
        USER_LOG.SEQ_LOG_ACTIONS_VRS.NEXTVAL,
        SYSDATE,
        P_LOG_TYPE,
        'SERIES_INTERVAL',
        VALCLOB,
        1,
        2,
        P_RECORD_ID
    );
END;
/
ALTER TRIGGER "VRS"."SERIES_INTERVAL_TRG_UI" ENABLE;
--------------------------------------------------------
--  DDL for Trigger SERIES_NUMBER_TRG
--------------------------------------------------------

  CREATE OR REPLACE EDITIONABLE TRIGGER "VRS"."SERIES_NUMBER_TRG" 
BEFORE INSERT ON VRS.SERIES_NUMBER 
FOR EACH ROW 
BEGIN
  <<COLUMN_SEQUENCES>>
  BEGIN
    IF INSERTING AND :NEW.ID IS NULL THEN
      SELECT SERIES_NUMBER_SEQ.NEXTVAL INTO :NEW.ID FROM SYS.DUAL;
    END IF;
  END COLUMN_SEQUENCES;
END;

/
ALTER TRIGGER "VRS"."SERIES_NUMBER_TRG" ENABLE;
--------------------------------------------------------
--  DDL for Trigger SERIES_NUMBER_TRG_UI
--------------------------------------------------------

  CREATE OR REPLACE EDITIONABLE TRIGGER "VRS"."SERIES_NUMBER_TRG_UI" 
AFTER DELETE OR UPDATE ON VRS.SERIES_NUMBER 
  FOR EACH ROW
DECLARE
    VALJSON PLJSON;
    VALCLOB CLOB;
    P_RECORD_ID NUMBER;
    P_LOG_TYPE NUMBER;
BEGIN
  DBMS_LOB.CREATETEMPORARY(VALCLOB, TRUE);
  VALJSON:=PLJSON();
  
  P_RECORD_ID:=:NEW.ID;
  IF(INSERTING) THEN
    P_LOG_TYPE:=1;
  ELSIF(UPDATING) THEN
    P_LOG_TYPE:=2;
  ELSIF(DELETING) THEN
    P_LOG_TYPE:=3;
    P_RECORD_ID:=:OLD.ID;
  END IF;
IF(INSERTING OR UPDATING) THEN
  VALJSON.PUT('ID',:NEW.ID);
  VALJSON.PUT('CREATE_DATE',:NEW.CREATE_DATE);
  VALJSON.PUT('NAME',:NEW.NAME);
  VALJSON.PUT('UPDATE_DATE',:NEW.UPDATE_DATE);
  VALJSON.PUT('IS_GIVEN',:NEW.IS_GIVEN);
  VALJSON.PUT('IS_HIDDEN',:NEW.IS_HIDDEN);
  VALJSON.PUT('IS_LOCAL',:NEW.IS_LOCAL);
  VALJSON.PUT('IS_OPENED',:NEW.IS_OPENED);
  VALJSON.PUT('LIMITED_DAY',:NEW.LIMITED_DAY);
  VALJSON.PUT('NO',:NEW.NO);
  VALJSON.PUT('ORDER_DATE',:NEW.ORDER_DATE);
  VALJSON.PUT('ORDER_USER',:NEW.ORDER_USER);
  VALJSON.PUT('TYPE',:NEW.TYPE);
  VALJSON.PUT('CREATED_BY_ID',:NEW.CREATED_BY_ID);
  VALJSON.PUT('UPDATED_BY_ID',:NEW.UPDATED_BY_ID);
  VALJSON.PUT('LOCAL_USER_ID',:NEW.LOCAL_USER_ID);
  VALJSON.PUT('SERIES_ID',:NEW.SERIES_ID);
  VALJSON.PUT('VEHICLE_ID',:NEW.VEHICLE_ID);
  VALJSON.PUT('IS_ORDER',:NEW.IS_ORDER);
  VALJSON.PUT('IS_AUTO',:NEW.IS_AUTO);
  VALJSON.PUT('SHOW_DATE',:NEW.SHOW_DATE);
  VALJSON.PUT('ORDER_CABIN',:NEW.ORDER_CABIN);
  VALJSON.PUT('IP_ADDRESS',:NEW.IP_ADDRESS);
  VALJSON.PUT('ISAUCTION',:NEW.ISAUCTION);
END IF;
IF(UPDATING OR DELETING) THEN
  VALJSON.PUT('ID',:OLD.ID);
  VALJSON.PUT('CREATE_DATE',:OLD.CREATE_DATE);
  VALJSON.PUT('NAME',:OLD.NAME);
  VALJSON.PUT('UPDATE_DATE',:OLD.UPDATE_DATE);
  VALJSON.PUT('IS_GIVEN',:OLD.IS_GIVEN);
  VALJSON.PUT('IS_HIDDEN',:OLD.IS_HIDDEN);
  VALJSON.PUT('IS_LOCAL',:OLD.IS_LOCAL);
  VALJSON.PUT('IS_OPENED',:OLD.IS_OPENED);
  VALJSON.PUT('LIMITED_DAY',:OLD.LIMITED_DAY);
  VALJSON.PUT('NO',:OLD.NO);
  VALJSON.PUT('ORDER_DATE',:OLD.ORDER_DATE);
  VALJSON.PUT('ORDER_USER',:OLD.ORDER_USER);
  VALJSON.PUT('TYPE',:OLD.TYPE);
  VALJSON.PUT('CREATED_BY_ID',:OLD.CREATED_BY_ID);
  VALJSON.PUT('UPDATED_BY_ID',:OLD.UPDATED_BY_ID);
  VALJSON.PUT('LOCAL_USER_ID',:OLD.LOCAL_USER_ID);
  VALJSON.PUT('SERIES_ID',:OLD.SERIES_ID);
  VALJSON.PUT('VEHICLE_ID',:OLD.VEHICLE_ID);
  VALJSON.PUT('IS_ORDER',:OLD.IS_ORDER);
  VALJSON.PUT('IS_AUTO',:OLD.IS_AUTO);
  VALJSON.PUT('SHOW_DATE',:OLD.SHOW_DATE);
  VALJSON.PUT('ORDER_CABIN',:OLD.ORDER_CABIN);
  VALJSON.PUT('IP_ADDRESS',:OLD.IP_ADDRESS);
  VALJSON.PUT('ISAUCTION',:OLD.ISAUCTION);
END IF;
  VALJSON.TO_CLOB(VALCLOB,FALSE,0,TRUE);
  INSERT INTO USER_LOG.LOG_ACTIONS_VRS (
    ID,
    LOG_DATE,
    LOG_TYPE,
    TABLE_NAME,
    JSON_VAL,
    STATUS,
    ACTION_TYPE,
    RECORD_ID
    ) VALUES (
        USER_LOG.SEQ_LOG_ACTIONS_VRS.NEXTVAL,
        SYSDATE,
        P_LOG_TYPE,
        'SERIES_NUMBER',
        VALCLOB,
        1,
        2,
        P_RECORD_ID
    );
END;
/
ALTER TRIGGER "VRS"."SERIES_NUMBER_TRG_UI" ENABLE;
--------------------------------------------------------
--  DDL for Trigger SERIES_TRG
--------------------------------------------------------

  CREATE OR REPLACE EDITIONABLE TRIGGER "VRS"."SERIES_TRG" 
BEFORE INSERT ON SERIES 
FOR EACH ROW 
BEGIN
  <<COLUMN_SEQUENCES>>
  BEGIN
    IF INSERTING AND :NEW.ID IS NULL THEN
      SELECT SERIES_SEQ.NEXTVAL INTO :NEW.ID FROM SYS.DUAL;
    END IF;
  END COLUMN_SEQUENCES;
END;





/
ALTER TRIGGER "VRS"."SERIES_TRG" ENABLE;
--------------------------------------------------------
--  DDL for Trigger SERIES_TRG_UI
--------------------------------------------------------

  CREATE OR REPLACE EDITIONABLE TRIGGER "VRS"."SERIES_TRG_UI" 
AFTER DELETE OR INSERT OR UPDATE ON VRS.SERIES 
  FOR EACH ROW
DECLARE
    VALJSON PLJSON;
    VALCLOB CLOB;
    P_RECORD_ID NUMBER;
    P_LOG_TYPE NUMBER;
BEGIN
  DBMS_LOB.CREATETEMPORARY(VALCLOB, TRUE);
  VALJSON:=PLJSON();
  
  P_RECORD_ID:=:NEW.ID;
  IF(INSERTING) THEN
    P_LOG_TYPE:=1;
  ELSIF(UPDATING) THEN
    P_LOG_TYPE:=2;
  ELSIF(DELETING) THEN
    P_LOG_TYPE:=3;
    P_RECORD_ID:=:OLD.ID;
  END IF;
IF(INSERTING OR UPDATING) THEN
  VALJSON.PUT('ID',:NEW.ID);
  VALJSON.PUT('CREATE_DATE',:NEW.CREATE_DATE);
  VALJSON.PUT('NAME',:NEW.NAME);
  VALJSON.PUT('UPDATE_DATE',:NEW.UPDATE_DATE);
  VALJSON.PUT('CREATED_BY_ID',:NEW.CREATED_BY_ID);
  VALJSON.PUT('UPDATED_BY_ID',:NEW.UPDATED_BY_ID);
  VALJSON.PUT('TYPE',:NEW.TYPE);
  VALJSON.PUT('PROVINCE_ID',:NEW.PROVINCE_ID);
  VALJSON.PUT('IS_DUPLICATE',:NEW.IS_DUPLICATE);
  VALJSON.PUT('IS_OLD',:NEW.IS_OLD);
  VALJSON.PUT('IS_CHECK_ADDRESS',:NEW.IS_CHECK_ADDRESS);
END IF;
IF(UPDATING OR DELETING) THEN
  VALJSON.PUT('ID',:OLD.ID);
  VALJSON.PUT('CREATE_DATE',:OLD.CREATE_DATE);
  VALJSON.PUT('NAME',:OLD.NAME);
  VALJSON.PUT('UPDATE_DATE',:OLD.UPDATE_DATE);
  VALJSON.PUT('CREATED_BY_ID',:OLD.CREATED_BY_ID);
  VALJSON.PUT('UPDATED_BY_ID',:OLD.UPDATED_BY_ID);
  VALJSON.PUT('TYPE',:OLD.TYPE);
  VALJSON.PUT('PROVINCE_ID',:OLD.PROVINCE_ID);
  VALJSON.PUT('IS_DUPLICATE',:OLD.IS_DUPLICATE);
  VALJSON.PUT('IS_OLD',:OLD.IS_OLD);
  VALJSON.PUT('IS_CHECK_ADDRESS',:OLD.IS_CHECK_ADDRESS);
END IF;
  VALJSON.TO_CLOB(VALCLOB,FALSE,0,TRUE);
  INSERT INTO USER_LOG.LOG_ACTIONS_VRS (
    ID,
    LOG_DATE,
    LOG_TYPE,
    TABLE_NAME,
    JSON_VAL,
    STATUS,
    ACTION_TYPE,
    RECORD_ID
    ) VALUES (
        USER_LOG.SEQ_LOG_ACTIONS_VRS.NEXTVAL,
        SYSDATE,
        P_LOG_TYPE,
        'SERIES',
        VALCLOB,
        1,
        2,
        P_RECORD_ID
    );
END;
/
ALTER TRIGGER "VRS"."SERIES_TRG_UI" ENABLE;
--------------------------------------------------------
--  DDL for Trigger SYSTEM_ARCHIVE_AFTER_INSERT
--------------------------------------------------------

  CREATE OR REPLACE EDITIONABLE TRIGGER "VRS"."SYSTEM_ARCHIVE_AFTER_INSERT" 
AFTER INSERT OR UPDATE ON SYSTEM_ARCHIVE 
FOR EACH ROW
BEGIN
    IF(INSERTING) THEN
        INSERT INTO ARCHIVE_NUMBER 
        (ARCHIVE_DEPARTMENT_ID, YEAR, MONTH, ABBR,NEW_COUNT,DELETE_COUNT, OTHER_COUNT, CREATEDDATE, UPDATEDDATE, CREATEDBY, MODIFIEDBY) 
        VALUES(:NEW.DEPARTMENTID, TO_CHAR(sysdate, ('YYYY')), TO_CHAR(sysdate, ('MM')), :NEW.ABBR, 0, 0, 0, :NEW.CREATEDDATE, :NEW.MODIFIEDDATE, :NEW.CREATEDBY, :NEW.MODIFIEDBY);
    END IF;
    IF(UPDATING) THEN
        UPDATE ARCHIVE_NUMBER SET 
        ARCHIVE_DEPARTMENT_ID=:NEW.DEPARTMENTID, ABBR = :NEW.ABBR, UPDATEDDATE = :NEW.MODIFIEDDATE, MODIFIEDBY = :NEW.MODIFIEDBY WHERE ABBR = :OLD.ABBR AND ARCHIVE_DEPARTMENT_ID = :OLD.DEPARTMENTID AND YEAR = TO_CHAR(sysdate, ('YYYY')) AND MONTH = TO_CHAR(sysdate, ('MM'));
    END IF;
END;







/
ALTER TRIGGER "VRS"."SYSTEM_ARCHIVE_AFTER_INSERT" ENABLE;
--------------------------------------------------------
--  DDL for Trigger SYSTEM_ARCHIVE_TRG
--------------------------------------------------------

  CREATE OR REPLACE EDITIONABLE TRIGGER "VRS"."SYSTEM_ARCHIVE_TRG" 
BEFORE INSERT ON SYSTEM_ARCHIVE 
FOR EACH ROW 
BEGIN
  <<COLUMN_SEQUENCES>>
  BEGIN
    IF INSERTING AND :NEW.ID IS NULL THEN
      SELECT SYSTEM_ARCHIVE_SEQ.NEXTVAL INTO :NEW.ID FROM SYS.DUAL;
    END IF;
  END COLUMN_SEQUENCES;
END;







/
ALTER TRIGGER "VRS"."SYSTEM_ARCHIVE_TRG" ENABLE;
--------------------------------------------------------
--  DDL for Trigger SYSTEM_ARCHIVE_TRG_UI
--------------------------------------------------------

  CREATE OR REPLACE EDITIONABLE TRIGGER "VRS"."SYSTEM_ARCHIVE_TRG_UI" 
AFTER DELETE OR INSERT OR UPDATE ON VRS.SYSTEM_ARCHIVE 
  FOR EACH ROW
DECLARE
    VALJSON PLJSON;
    VALCLOB CLOB;
    P_RECORD_ID NUMBER;
    P_LOG_TYPE NUMBER;
BEGIN
  DBMS_LOB.CREATETEMPORARY(VALCLOB, TRUE);
  VALJSON:=PLJSON();
  
  P_RECORD_ID:=:NEW.ID;
  IF(INSERTING) THEN
    P_LOG_TYPE:=1;
  ELSIF(UPDATING) THEN
    P_LOG_TYPE:=2;
  ELSIF(DELETING) THEN
    P_LOG_TYPE:=3;
    P_RECORD_ID:=:OLD.ID;
  END IF;
IF(INSERTING OR UPDATING) THEN
  VALJSON.PUT('ID',:NEW.ID);
  VALJSON.PUT('PROVINCEID',:NEW.PROVINCEID);
  VALJSON.PUT('DEPARTMENTID',:NEW.DEPARTMENTID);
  VALJSON.PUT('ARCHIVE',:NEW.ARCHIVE);
  VALJSON.PUT('ABBR',:NEW.ABBR);
  VALJSON.PUT('CREATEDBY',:NEW.CREATEDBY);
  VALJSON.PUT('MODIFIEDBY',:NEW.MODIFIEDBY);
  VALJSON.PUT('CREATEDDATE',:NEW.CREATEDDATE);
  VALJSON.PUT('MODIFIEDDATE',:NEW.MODIFIEDDATE);
  VALJSON.PUT('DELETED_AT',:NEW.DELETED_AT);
END IF;
IF(UPDATING OR DELETING) THEN
  VALJSON.PUT('ID',:OLD.ID);
  VALJSON.PUT('PROVINCEID',:OLD.PROVINCEID);
  VALJSON.PUT('DEPARTMENTID',:OLD.DEPARTMENTID);
  VALJSON.PUT('ARCHIVE',:OLD.ARCHIVE);
  VALJSON.PUT('ABBR',:OLD.ABBR);
  VALJSON.PUT('CREATEDBY',:OLD.CREATEDBY);
  VALJSON.PUT('MODIFIEDBY',:OLD.MODIFIEDBY);
  VALJSON.PUT('CREATEDDATE',:OLD.CREATEDDATE);
  VALJSON.PUT('MODIFIEDDATE',:OLD.MODIFIEDDATE);
  VALJSON.PUT('DELETED_AT',:OLD.DELETED_AT);
END IF;
  VALJSON.TO_CLOB(VALCLOB,FALSE,0,TRUE);
  INSERT INTO USER_LOG.LOG_ACTIONS_VRS (
    ID,
    LOG_DATE,
    LOG_TYPE,
    TABLE_NAME,
    JSON_VAL,
    STATUS,
    ACTION_TYPE,
    RECORD_ID
    ) VALUES (
        USER_LOG.SEQ_LOG_ACTIONS_VRS.NEXTVAL,
        SYSDATE,
        P_LOG_TYPE,
        'SYSTEM_ARCHIVE',
        VALCLOB,
        1,
        2,
        P_RECORD_ID
    );
END;
/
ALTER TRIGGER "VRS"."SYSTEM_ARCHIVE_TRG_UI" ENABLE;
--------------------------------------------------------
--  DDL for Trigger SYSTEM_DEPARTMENT_TRG
--------------------------------------------------------

  CREATE OR REPLACE EDITIONABLE TRIGGER "VRS"."SYSTEM_DEPARTMENT_TRG" 
BEFORE INSERT ON SYSTEM_DEPARTMENT 
FOR EACH ROW 
BEGIN
  <<COLUMN_SEQUENCES>>
  BEGIN
    IF INSERTING AND :NEW.ID IS NULL THEN
      SELECT SYSTEM_DEPARTMENT_SEQ.NEXTVAL INTO :NEW.ID FROM SYS.DUAL;
    END IF;
  END COLUMN_SEQUENCES;
END;






/
ALTER TRIGGER "VRS"."SYSTEM_DEPARTMENT_TRG" ENABLE;
--------------------------------------------------------
--  DDL for Trigger SYSTEM_DEPARTMENT_TRG_UI
--------------------------------------------------------

  CREATE OR REPLACE EDITIONABLE TRIGGER "VRS"."SYSTEM_DEPARTMENT_TRG_UI" 
AFTER DELETE OR INSERT OR UPDATE ON VRS.SYSTEM_DEPARTMENT 
  FOR EACH ROW
DECLARE
    VALJSON PLJSON;
    VALCLOB CLOB;
    P_RECORD_ID NUMBER;
    P_LOG_TYPE NUMBER;
BEGIN
  DBMS_LOB.CREATETEMPORARY(VALCLOB, TRUE);
  VALJSON:=PLJSON();
  
  P_RECORD_ID:=:NEW.ID;
  IF(INSERTING) THEN
    P_LOG_TYPE:=1;
  ELSIF(UPDATING) THEN
    P_LOG_TYPE:=2;
  ELSIF(DELETING) THEN
    P_LOG_TYPE:=3;
    P_RECORD_ID:=:OLD.ID;
  END IF;
IF(INSERTING OR UPDATING) THEN
  VALJSON.PUT('ID',:NEW.ID);
  VALJSON.PUT('CREATEDDATE',:NEW.CREATEDDATE);
  VALJSON.PUT('NAME',:NEW.NAME);
  VALJSON.PUT('MODIFIEDDATE',:NEW.MODIFIEDDATE);
  VALJSON.PUT('CREATEDBY',:NEW.CREATEDBY);
  VALJSON.PUT('MODIFIEDBY',:NEW.MODIFIEDBY);
  VALJSON.PUT('DELETED_AT',:NEW.DELETED_AT);
  VALJSON.PUT('PROVINCE_ID',:NEW.PROVINCE_ID);
  VALJSON.PUT('DEPARTMENT_TYPE',:NEW.DEPARTMENT_TYPE);
  VALJSON.PUT('DEP_LICENSE_NUMBER',:NEW.DEP_LICENSE_NUMBER);
  VALJSON.PUT('DEP_LICENSE_START_DATE',:NEW.DEP_LICENSE_START_DATE);
  VALJSON.PUT('DEP_REGISTER',:NEW.DEP_REGISTER);
  VALJSON.PUT('DEP_ADDRESS',:NEW.DEP_ADDRESS);
  VALJSON.PUT('DEP_PHONE',:NEW.DEP_PHONE);
  VALJSON.PUT('DEP_DIRECTOR',:NEW.DEP_DIRECTOR);
  VALJSON.PUT('DEP_LICENSE_END_DATE',:NEW.DEP_LICENSE_END_DATE);
END IF;
IF(UPDATING OR DELETING) THEN
  VALJSON.PUT('ID',:OLD.ID);
  VALJSON.PUT('CREATEDDATE',:OLD.CREATEDDATE);
  VALJSON.PUT('NAME',:OLD.NAME);
  VALJSON.PUT('MODIFIEDDATE',:OLD.MODIFIEDDATE);
  VALJSON.PUT('CREATEDBY',:OLD.CREATEDBY);
  VALJSON.PUT('MODIFIEDBY',:OLD.MODIFIEDBY);
  VALJSON.PUT('DELETED_AT',:OLD.DELETED_AT);
  VALJSON.PUT('PROVINCE_ID',:OLD.PROVINCE_ID);
  VALJSON.PUT('DEPARTMENT_TYPE',:OLD.DEPARTMENT_TYPE);
  VALJSON.PUT('DEP_LICENSE_NUMBER',:OLD.DEP_LICENSE_NUMBER);
  VALJSON.PUT('DEP_LICENSE_START_DATE',:OLD.DEP_LICENSE_START_DATE);
  VALJSON.PUT('DEP_REGISTER',:OLD.DEP_REGISTER);
  VALJSON.PUT('DEP_ADDRESS',:OLD.DEP_ADDRESS);
  VALJSON.PUT('DEP_PHONE',:OLD.DEP_PHONE);
  VALJSON.PUT('DEP_DIRECTOR',:OLD.DEP_DIRECTOR);
  VALJSON.PUT('DEP_LICENSE_END_DATE',:OLD.DEP_LICENSE_END_DATE);
END IF;
  VALJSON.TO_CLOB(VALCLOB,FALSE,0,TRUE);
  INSERT INTO USER_LOG.LOG_ACTIONS_VRS (
    ID,
    LOG_DATE,
    LOG_TYPE,
    TABLE_NAME,
    JSON_VAL,
    STATUS,
    ACTION_TYPE,
    RECORD_ID
    ) VALUES (
        USER_LOG.SEQ_LOG_ACTIONS_VRS.NEXTVAL,
        SYSDATE,
        P_LOG_TYPE,
        'SYSTEM_DEPARTMENT',
        VALCLOB,
        1,
        2,
        P_RECORD_ID
    );
END;
/
ALTER TRIGGER "VRS"."SYSTEM_DEPARTMENT_TRG_UI" ENABLE;
--------------------------------------------------------
--  DDL for Trigger SYSTEM_DEPTYPE_TRG
--------------------------------------------------------

  CREATE OR REPLACE EDITIONABLE TRIGGER "VRS"."SYSTEM_DEPTYPE_TRG" 
BEFORE INSERT ON VRS.SYSTEM_DEPTYPE 
FOR EACH ROW 
BEGIN
  <<COLUMN_SEQUENCES>>
  BEGIN
    IF INSERTING AND :NEW.ID IS NULL THEN
      SELECT SYSTEM_DEPTYPE_SEQ.NEXTVAL INTO :NEW.ID FROM SYS.DUAL;
    END IF;
  END COLUMN_SEQUENCES;
END;



/
ALTER TRIGGER "VRS"."SYSTEM_DEPTYPE_TRG" ENABLE;
--------------------------------------------------------
--  DDL for Trigger SYSTEM_ISSUE_TRG
--------------------------------------------------------

  CREATE OR REPLACE EDITIONABLE TRIGGER "VRS"."SYSTEM_ISSUE_TRG" 
BEFORE INSERT ON SYSTEM_ISSUE 
FOR EACH ROW 
BEGIN
  <<COLUMN_SEQUENCES>>
  BEGIN
    IF INSERTING AND :NEW.QUESTION_IMAGE IS NULL THEN
      SELECT SYSTEM_ISSUE_SEQ.NEXTVAL INTO :NEW.QUESTION_IMAGE FROM SYS.DUAL;
    END IF;
  END COLUMN_SEQUENCES;
END;






/
ALTER TRIGGER "VRS"."SYSTEM_ISSUE_TRG" ENABLE;
--------------------------------------------------------
--  DDL for Trigger SYSTEM_ISSUE_TRG1
--------------------------------------------------------

  CREATE OR REPLACE EDITIONABLE TRIGGER "VRS"."SYSTEM_ISSUE_TRG1" 
BEFORE INSERT ON SYSTEM_ISSUE 
FOR EACH ROW 
BEGIN
  <<COLUMN_SEQUENCES>>
  BEGIN
    IF INSERTING AND :NEW.ID IS NULL THEN
      SELECT SYSTEM_ISSUE_SEQ1.NEXTVAL INTO :NEW.ID FROM SYS.DUAL;
    END IF;
  END COLUMN_SEQUENCES;
END;






/
ALTER TRIGGER "VRS"."SYSTEM_ISSUE_TRG1" ENABLE;
--------------------------------------------------------
--  DDL for Trigger SYSTEM_PLATE_FACTORY_TRG
--------------------------------------------------------

  CREATE OR REPLACE EDITIONABLE TRIGGER "VRS"."SYSTEM_PLATE_FACTORY_TRG" 
BEFORE INSERT ON SYSTEM_PLATE_FACTORY 
FOR EACH ROW 
BEGIN
  <<COLUMN_SEQUENCES>>
  BEGIN
    IF INSERTING AND :NEW.ID IS NULL THEN
      SELECT SYSTEM_PLATE_FACTORY_SEQ.NEXTVAL INTO :NEW.ID FROM SYS.DUAL;
    END IF;
    IF INSERTING AND :NEW.IS_PRINT IS NULL THEN
      SELECT SYSTEM_PLATE_FACTORY_SEQ.NEXTVAL INTO :NEW.IS_PRINT FROM SYS.DUAL;
    END IF;
  END COLUMN_SEQUENCES;
END;






/
ALTER TRIGGER "VRS"."SYSTEM_PLATE_FACTORY_TRG" ENABLE;
--------------------------------------------------------
--  DDL for Trigger SYSTEM_POSITION_LOG_TRG
--------------------------------------------------------

  CREATE OR REPLACE EDITIONABLE TRIGGER "VRS"."SYSTEM_POSITION_LOG_TRG" 
BEFORE INSERT ON SYSTEM_POSITION_LOG 
FOR EACH ROW 
BEGIN
  <<COLUMN_SEQUENCES>>
  BEGIN
    IF INSERTING AND :NEW.ID IS NULL THEN
      SELECT SYSTEM_POSITION_LOG_SEQ.NEXTVAL INTO :NEW.ID FROM SYS.DUAL;
    END IF;
  END COLUMN_SEQUENCES;
END;



/
ALTER TRIGGER "VRS"."SYSTEM_POSITION_LOG_TRG" ENABLE;
--------------------------------------------------------
--  DDL for Trigger SYSTEM_POSITION_TRG
--------------------------------------------------------

  CREATE OR REPLACE EDITIONABLE TRIGGER "VRS"."SYSTEM_POSITION_TRG" BEFORE INSERT ON SYSTEM_POSITION 
FOR EACH ROW 
BEGIN
  <<COLUMN_SEQUENCES>>
  BEGIN
    IF INSERTING AND :NEW.ID IS NULL THEN
      SELECT SYSTEM_POSITION_SEQ.NEXTVAL INTO :NEW.ID FROM SYS.DUAL;
    END IF;
  END COLUMN_SEQUENCES;
END;






/
ALTER TRIGGER "VRS"."SYSTEM_POSITION_TRG" ENABLE;
--------------------------------------------------------
--  DDL for Trigger SYSTEM_POSITION_TRG_UI
--------------------------------------------------------

  CREATE OR REPLACE EDITIONABLE TRIGGER "VRS"."SYSTEM_POSITION_TRG_UI" 
AFTER DELETE OR INSERT OR UPDATE ON VRS.SYSTEM_POSITION 
  FOR EACH ROW
DECLARE
    VALJSON PLJSON;
    VALCLOB CLOB;
    P_RECORD_ID NUMBER;
    P_LOG_TYPE NUMBER;
BEGIN
  DBMS_LOB.CREATETEMPORARY(VALCLOB, TRUE);
  VALJSON:=PLJSON();
  
  P_RECORD_ID:=:NEW.ID;
  IF(INSERTING) THEN
    P_LOG_TYPE:=1;
  ELSIF(UPDATING) THEN
    P_LOG_TYPE:=2;
  ELSIF(DELETING) THEN
    P_LOG_TYPE:=3;
    P_RECORD_ID:=:OLD.ID;
  END IF;
IF(INSERTING OR UPDATING) THEN
  VALJSON.PUT('ID',:NEW.ID);
  VALJSON.PUT('NAME',:NEW.NAME);
  VALJSON.PUT('CREATEDBY',:NEW.CREATEDBY);
  VALJSON.PUT('MODIFIEDBY',:NEW.MODIFIEDBY);
  VALJSON.PUT('CREATEDDATE',:NEW.CREATEDDATE);
  VALJSON.PUT('MODIFIEDDATE',:NEW.MODIFIEDDATE);
  VALJSON.PUT('DELETED_AT',:NEW.DELETED_AT);
END IF;
IF(UPDATING OR DELETING) THEN
  VALJSON.PUT('ID',:OLD.ID);
  VALJSON.PUT('NAME',:OLD.NAME);
  VALJSON.PUT('CREATEDBY',:OLD.CREATEDBY);
  VALJSON.PUT('MODIFIEDBY',:OLD.MODIFIEDBY);
  VALJSON.PUT('CREATEDDATE',:OLD.CREATEDDATE);
  VALJSON.PUT('MODIFIEDDATE',:OLD.MODIFIEDDATE);
  VALJSON.PUT('DELETED_AT',:OLD.DELETED_AT);
END IF;
  VALJSON.TO_CLOB(VALCLOB,FALSE,0,TRUE);
  INSERT INTO USER_LOG.LOG_ACTIONS_VRS (
    ID,
    LOG_DATE,
    LOG_TYPE,
    TABLE_NAME,
    JSON_VAL,
    STATUS,
    ACTION_TYPE,
    RECORD_ID
    ) VALUES (
        USER_LOG.SEQ_LOG_ACTIONS_VRS.NEXTVAL,
        SYSDATE,
        P_LOG_TYPE,
        'SYSTEM_POSITION',
        VALCLOB,
        1,
        2,
        P_RECORD_ID
    );
END;
/
ALTER TRIGGER "VRS"."SYSTEM_POSITION_TRG_UI" ENABLE;
--------------------------------------------------------
--  DDL for Trigger SYSTEM_USER_MENU_TRG
--------------------------------------------------------

  CREATE OR REPLACE EDITIONABLE TRIGGER "VRS"."SYSTEM_USER_MENU_TRG" 
BEFORE INSERT ON SYSTEM_USER_MENU 
FOR EACH ROW 
BEGIN
  <<COLUMN_SEQUENCES>>
  BEGIN
    IF INSERTING AND :NEW.ID IS NULL THEN
      SELECT SYSTEM_USER_MENU_SEQ.NEXTVAL INTO :NEW.ID FROM SYS.DUAL;
    END IF;
  END COLUMN_SEQUENCES;
END;







/
ALTER TRIGGER "VRS"."SYSTEM_USER_MENU_TRG" ENABLE;
--------------------------------------------------------
--  DDL for Trigger SYSTEM_USER_MENU_TRG_UI
--------------------------------------------------------

  CREATE OR REPLACE EDITIONABLE TRIGGER "VRS"."SYSTEM_USER_MENU_TRG_UI" 
AFTER DELETE OR INSERT OR UPDATE ON VRS.SYSTEM_USER_MENU 
  FOR EACH ROW
DECLARE
    VALJSON PLJSON;
    VALCLOB CLOB;
    P_RECORD_ID NUMBER;
    P_LOG_TYPE NUMBER;
BEGIN
  DBMS_LOB.CREATETEMPORARY(VALCLOB, TRUE);
  VALJSON:=PLJSON();
  
  P_RECORD_ID:=:NEW.ID;
  IF(INSERTING) THEN
    P_LOG_TYPE:=1;
  ELSIF(UPDATING) THEN
    P_LOG_TYPE:=2;
  ELSIF(DELETING) THEN
    P_LOG_TYPE:=3;
    P_RECORD_ID:=:OLD.ID;
  END IF;
IF(INSERTING OR UPDATING) THEN
  VALJSON.PUT('ID',:NEW.ID);
  VALJSON.PUT('CREATEDDATE',:NEW.CREATEDDATE);
  VALJSON.PUT('NAME',:NEW.NAME);
  VALJSON.PUT('UPDATEDDATE',:NEW.UPDATEDDATE);
  VALJSON.PUT('ACTION_ID',:NEW.ACTION_ID);
  VALJSON.PUT('POSITION_ID',:NEW.POSITION_ID);
  VALJSON.PUT('CREATEDBY',:NEW.CREATEDBY);
  VALJSON.PUT('UPDATEDBY',:NEW.UPDATEDBY);
  VALJSON.PUT('TYPE_ID',:NEW.TYPE_ID);
END IF;
IF(UPDATING OR DELETING) THEN
  VALJSON.PUT('ID',:OLD.ID);
  VALJSON.PUT('CREATEDDATE',:OLD.CREATEDDATE);
  VALJSON.PUT('NAME',:OLD.NAME);
  VALJSON.PUT('UPDATEDDATE',:OLD.UPDATEDDATE);
  VALJSON.PUT('ACTION_ID',:OLD.ACTION_ID);
  VALJSON.PUT('POSITION_ID',:OLD.POSITION_ID);
  VALJSON.PUT('CREATEDBY',:OLD.CREATEDBY);
  VALJSON.PUT('UPDATEDBY',:OLD.UPDATEDBY);
  VALJSON.PUT('TYPE_ID',:OLD.TYPE_ID);
END IF;
  VALJSON.TO_CLOB(VALCLOB,FALSE,0,TRUE);
  INSERT INTO USER_LOG.LOG_ACTIONS_VRS (
    ID,
    LOG_DATE,
    LOG_TYPE,
    TABLE_NAME,
    JSON_VAL,
    STATUS,
    ACTION_TYPE,
    RECORD_ID
    ) VALUES (
        USER_LOG.SEQ_LOG_ACTIONS_VRS.NEXTVAL,
        SYSDATE,
        P_LOG_TYPE,
        'SYSTEM_USER_MENU',
        VALCLOB,
        1,
        2,
        P_RECORD_ID
    );
END;
/
ALTER TRIGGER "VRS"."SYSTEM_USER_MENU_TRG_UI" ENABLE;
--------------------------------------------------------
--  DDL for Trigger SYSTEM_USER_TRG
--------------------------------------------------------

  CREATE OR REPLACE EDITIONABLE TRIGGER "VRS"."SYSTEM_USER_TRG" 
BEFORE INSERT ON SYSTEM_USER 
FOR EACH ROW 
BEGIN
  <<COLUMN_SEQUENCES>>
  BEGIN
    IF INSERTING AND :NEW.ID IS NULL THEN
      SELECT SYSTEM_USER_SEQ.NEXTVAL INTO :NEW.ID FROM SYS.DUAL;
    END IF;
  END COLUMN_SEQUENCES;
END;





/
ALTER TRIGGER "VRS"."SYSTEM_USER_TRG" ENABLE;
--------------------------------------------------------
--  DDL for Trigger SYSTEM_USER_TRG_UI
--------------------------------------------------------

  CREATE OR REPLACE EDITIONABLE TRIGGER "VRS"."SYSTEM_USER_TRG_UI" 
AFTER DELETE OR INSERT OR UPDATE ON VRS.SYSTEM_USER 
  FOR EACH ROW
DECLARE
    VALJSON PLJSON;
    VALCLOB CLOB;
    P_RECORD_ID NUMBER;
    P_LOG_TYPE NUMBER;
BEGIN
  DBMS_LOB.CREATETEMPORARY(VALCLOB, TRUE);
  VALJSON:=PLJSON();
  
  P_RECORD_ID:=:NEW.ID;
  IF(INSERTING) THEN
    P_LOG_TYPE:=1;
  ELSIF(UPDATING) THEN
    P_LOG_TYPE:=2;
  ELSIF(DELETING) THEN
    P_LOG_TYPE:=3;
    P_RECORD_ID:=:OLD.ID;
  END IF;
IF(INSERTING OR UPDATING) THEN
  VALJSON.PUT('ID',:NEW.ID);
  VALJSON.PUT('ISACTIVE',:NEW.ISACTIVE);
  VALJSON.PUT('CREATEDDATE',:NEW.CREATEDDATE);
  VALJSON.PUT('FIRSTNAME',:NEW.FIRSTNAME);
  VALJSON.PUT('LASTNAME',:NEW.LASTNAME);
  VALJSON.PUT('PASSWORD',:NEW.ID);
  VALJSON.PUT('MODIFIEDDATE',:NEW.MODIFIEDDATE);
  VALJSON.PUT('USERNAME',:NEW.USERNAME);
  VALJSON.PUT('PROVINCEID',:NEW.PROVINCEID);
  VALJSON.PUT('USERPOSITIONID',:NEW.USERPOSITIONID);
  VALJSON.PUT('PASSWORDANOTHER',:NEW.PASSWORDANOTHER);
  VALJSON.PUT('USERDEPARTMENTID',:NEW.USERDEPARTMENTID);
  VALJSON.PUT('CREATEDBY',:NEW.CREATEDBY);
  VALJSON.PUT('MODIFIEDBY',:NEW.MODIFIEDBY);
  VALJSON.PUT('DELETED_AT',:NEW.DELETED_AT);
  VALJSON.PUT('REMEMBER_TOKEN',:NEW.REMEMBER_TOKEN);
  VALJSON.PUT('SESSION_ID',:NEW.SESSION_ID);
  VALJSON.PUT('ISATVT',:NEW.ISATVT);
  VALJSON.PUT('LAST_CHANGE_PASSWORD',:NEW.LAST_CHANGE_PASSWORD);
END IF;
IF(UPDATING OR DELETING) THEN
  VALJSON.PUT('ID',:OLD.ID);
  VALJSON.PUT('ISACTIVE',:OLD.ISACTIVE);
  VALJSON.PUT('CREATEDDATE',:OLD.CREATEDDATE);
  VALJSON.PUT('FIRSTNAME',:OLD.FIRSTNAME);
  VALJSON.PUT('LASTNAME',:OLD.LASTNAME);
  VALJSON.PUT('PASSWORD',:OLD.ID);
  VALJSON.PUT('MODIFIEDDATE',:OLD.MODIFIEDDATE);
  VALJSON.PUT('USERNAME',:OLD.USERNAME);
  VALJSON.PUT('PROVINCEID',:OLD.PROVINCEID);
  VALJSON.PUT('USERPOSITIONID',:OLD.USERPOSITIONID);
  VALJSON.PUT('PASSWORDANOTHER',:OLD.PASSWORDANOTHER);
  VALJSON.PUT('USERDEPARTMENTID',:OLD.USERDEPARTMENTID);
  VALJSON.PUT('CREATEDBY',:OLD.CREATEDBY);
  VALJSON.PUT('MODIFIEDBY',:OLD.MODIFIEDBY);
  VALJSON.PUT('DELETED_AT',:OLD.DELETED_AT);
  VALJSON.PUT('REMEMBER_TOKEN',:OLD.REMEMBER_TOKEN);
  VALJSON.PUT('SESSION_ID',:OLD.SESSION_ID);
  VALJSON.PUT('ISATVT',:OLD.ISATVT);
  VALJSON.PUT('LAST_CHANGE_PASSWORD',:OLD.LAST_CHANGE_PASSWORD);
END IF;
  VALJSON.TO_CLOB(VALCLOB,FALSE,0,TRUE);
  INSERT INTO USER_LOG.LOG_ACTIONS_VRS (
    ID,
    LOG_DATE,
    LOG_TYPE,
    TABLE_NAME,
    JSON_VAL,
    STATUS,
    ACTION_TYPE,
    RECORD_ID
    ) VALUES (
        USER_LOG.SEQ_LOG_ACTIONS_VRS.NEXTVAL,
        SYSDATE,
        P_LOG_TYPE,
        'SYSTEM_USER',
        VALCLOB,
        1,
        2,
        P_RECORD_ID
    );
END;
/
ALTER TRIGGER "VRS"."SYSTEM_USER_TRG_UI" ENABLE;
--------------------------------------------------------
--  DDL for Trigger TRANSACTION_TRG
--------------------------------------------------------

  CREATE OR REPLACE EDITIONABLE TRIGGER "VRS"."TRANSACTION_TRG" 
BEFORE INSERT ON VRS.TRANSACTION 
FOR EACH ROW 
BEGIN
  <<COLUMN_SEQUENCES>>
  BEGIN
    IF INSERTING AND :NEW.ID IS NULL THEN
      SELECT TRANSACTION_SEQ.NEXTVAL INTO :NEW.ID FROM SYS.DUAL;
    END IF;
  END COLUMN_SEQUENCES;
END;

/
ALTER TRIGGER "VRS"."TRANSACTION_TRG" ENABLE;
--------------------------------------------------------
--  DDL for Trigger TRL_REF_COLOR
--------------------------------------------------------

  CREATE OR REPLACE EDITIONABLE TRIGGER "VRS"."TRL_REF_COLOR" 
  AFTER INSERT OR UPDATE OR DELETE ON VRS.REF_COLOR
  FOR EACH ROW
DECLARE
    VALJSON PLJSON;
    VALCLOB CLOB;
    P_RECORD_ID NUMBER;
    P_LOG_TYPE NUMBER;
BEGIN
  DBMS_LOB.CREATETEMPORARY(VALCLOB, TRUE);
  VALJSON:=PLJSON();
  
  P_RECORD_ID:=:NEW.ID;
  IF(INSERTING) THEN
    P_LOG_TYPE:=1;
  ELSIF(UPDATING) THEN
    P_LOG_TYPE:=2;
  ELSIF(DELETING) THEN
    P_LOG_TYPE:=3;
    P_RECORD_ID:=:OLD.ID;
  END IF;
IF(INSERTING OR UPDATING) THEN
  VALJSON.PUT('ID',:NEW.ID);
  VALJSON.PUT('NAME',:NEW.NAME);
  VALJSON.PUT('TYPE_ID',:NEW.TYPE_ID);
  VALJSON.PUT('STATUS',:NEW.STATUS);
END IF;
IF(UPDATING OR DELETING) THEN
  VALJSON.PUT('ID',:OLD.ID);
  VALJSON.PUT('NAME',:OLD.NAME);
  VALJSON.PUT('TYPE_ID',:OLD.TYPE_ID);
  VALJSON.PUT('STATUS',:OLD.STATUS);
END IF;
  VALJSON.TO_CLOB(VALCLOB,FALSE,0,TRUE);
  INSERT INTO USER_LOG.LOG_ACTIONS (
    ID,
    LOG_DATE,
    LOG_TYPE,
    TABLE_NAME,
    JSON_VAL,
    STATUS,
    ACTION_TYPE,
    RECORD_ID
    ) VALUES (
        USER_LOG.SEQ_LOG_ACTIONS.NEXTVAL,
        SYSDATE,
        P_LOG_TYPE,
        'REF_COLOR',
        VALCLOB,
        1,
        1,
        P_RECORD_ID
    );
END;
/
ALTER TRIGGER "VRS"."TRL_REF_COLOR" ENABLE;
--------------------------------------------------------
--  DDL for Trigger TRL_REF_COUNTRY
--------------------------------------------------------

  CREATE OR REPLACE EDITIONABLE TRIGGER "VRS"."TRL_REF_COUNTRY" 
  AFTER INSERT OR UPDATE OR DELETE ON VRS.REF_COUNTRY
  FOR EACH ROW
DECLARE
    VALJSON PLJSON;
    VALCLOB CLOB;
    P_RECORD_ID NUMBER;
    P_LOG_TYPE NUMBER;
BEGIN
  DBMS_LOB.CREATETEMPORARY(VALCLOB, TRUE);
  VALJSON:=PLJSON();
  
  P_RECORD_ID:=:NEW.ID;
  IF(INSERTING) THEN
    P_LOG_TYPE:=1;
  ELSIF(UPDATING) THEN
    P_LOG_TYPE:=2;
  ELSIF(DELETING) THEN
    P_LOG_TYPE:=3;
    P_RECORD_ID:=:OLD.ID;
  END IF;
IF(INSERTING OR UPDATING) THEN
  VALJSON.PUT('ID',:NEW.ID);
  VALJSON.PUT('CREATED_DATE',TO_CHAR(:NEW.CREATED_DATE, 'YYYY-MM-DD HH24:MI:SS'));
  VALJSON.PUT('NAME',:NEW.NAME);
  VALJSON.PUT('UPDATED_DATE',TO_CHAR(:NEW.UPDATED_DATE, 'YYYY-MM-DD HH24:MI:SS'));
  VALJSON.PUT('CODE',:NEW.CODE);
  VALJSON.PUT('CREATED_BY',:NEW.CREATED_BY);
  VALJSON.PUT('UPDATED_BY',:NEW.UPDATED_BY);
  VALJSON.PUT('STATUS',:NEW.STATUS);
END IF;
IF(UPDATING OR DELETING) THEN
  VALJSON.PUT('ID',:OLD.ID);
  VALJSON.PUT('CREATED_DATE',TO_CHAR(:OLD.CREATED_DATE, 'YYYY-MM-DD HH24:MI:SS'));
  VALJSON.PUT('NAME',:OLD.NAME);
  VALJSON.PUT('UPDATED_DATE',TO_CHAR(:OLD.UPDATED_DATE, 'YYYY-MM-DD HH24:MI:SS'));
  VALJSON.PUT('CODE',:OLD.CODE);
  VALJSON.PUT('CREATED_BY',:OLD.CREATED_BY);
  VALJSON.PUT('UPDATED_BY',:OLD.UPDATED_BY);
  VALJSON.PUT('STATUS',:OLD.STATUS);
END IF;
  VALJSON.TO_CLOB(VALCLOB,FALSE,0,TRUE);
  INSERT INTO USER_LOG.LOG_ACTIONS (
    ID,
    LOG_DATE,
    LOG_TYPE,
    TABLE_NAME,
    JSON_VAL,
    STATUS,
    ACTION_TYPE,
    RECORD_ID
    ) VALUES (
        USER_LOG.SEQ_LOG_ACTIONS.NEXTVAL,
        SYSDATE,
        P_LOG_TYPE,
        'REF_COUNTRY',
        VALCLOB,
        1,
        1,
        P_RECORD_ID
    );
END;
/
ALTER TRIGGER "VRS"."TRL_REF_COUNTRY" ENABLE;
--------------------------------------------------------
--  DDL for Trigger TRL_REF_ENGINE_MODEL
--------------------------------------------------------

  CREATE OR REPLACE EDITIONABLE TRIGGER "VRS"."TRL_REF_ENGINE_MODEL" 
  AFTER INSERT OR UPDATE OR DELETE ON VRS.REF_ENGINE_MODEL
  FOR EACH ROW
DECLARE
    VALJSON PLJSON;
    VALCLOB CLOB;
    P_RECORD_ID NUMBER;
    P_LOG_TYPE NUMBER;
BEGIN
  DBMS_LOB.CREATETEMPORARY(VALCLOB, TRUE);
  VALJSON:=PLJSON();
  
  P_RECORD_ID:=:NEW.ID;
  IF(INSERTING) THEN
    P_LOG_TYPE:=1;
  ELSIF(UPDATING) THEN
    P_LOG_TYPE:=2;
  ELSIF(DELETING) THEN
    P_LOG_TYPE:=3;
    P_RECORD_ID:=:OLD.ID;
  END IF;
IF(INSERTING OR UPDATING) THEN
  VALJSON.PUT('ID',:NEW.ID);
  VALJSON.PUT('NAME',:NEW.NAME);
  VALJSON.PUT('FUEL_TYPE_ID',:NEW.FUEL_TYPE_ID);
  VALJSON.PUT('ECO_CLASS_ID',:NEW.ECO_CLASS_ID);
  VALJSON.PUT('STATUS',:NEW.STATUS);
  VALJSON.PUT('ENGINE_CAPACITY',:NEW.ENGINE_CAPACITY);
  VALJSON.PUT('ENGINE_POWER',:NEW.ENGINE_POWER);
  VALJSON.PUT('OCTANE_NUM_ID',:NEW.OCTANE_NUM_ID);
  VALJSON.PUT('IS_TURBO',:NEW.IS_TURBO);
  VALJSON.PUT('UPDATED_BY',:NEW.UPDATED_BY);
  VALJSON.PUT('UPDATED_DATE',TO_CHAR(:NEW.UPDATED_DATE, 'YYYY-MM-DD HH24:MI:SS'));
  VALJSON.PUT('CREATED_BY',:NEW.CREATED_BY);
  VALJSON.PUT('CREATED_DATE',TO_CHAR(:NEW.CREATED_DATE, 'YYYY-MM-DD HH24:MI:SS'));
END IF;
IF(UPDATING OR DELETING) THEN
  VALJSON.PUT('ID',:OLD.ID);
  VALJSON.PUT('NAME',:OLD.NAME);
  VALJSON.PUT('FUEL_TYPE_ID',:OLD.FUEL_TYPE_ID);
  VALJSON.PUT('ECO_CLASS_ID',:OLD.ECO_CLASS_ID);
  VALJSON.PUT('STATUS',:OLD.STATUS);
  VALJSON.PUT('ENGINE_CAPACITY',:OLD.ENGINE_CAPACITY);
  VALJSON.PUT('ENGINE_POWER',:OLD.ENGINE_POWER);
  VALJSON.PUT('OCTANE_NUM_ID',:OLD.OCTANE_NUM_ID);
  VALJSON.PUT('IS_TURBO',:OLD.IS_TURBO);
  VALJSON.PUT('UPDATED_BY',:OLD.UPDATED_BY);
  VALJSON.PUT('UPDATED_DATE',TO_CHAR(:OLD.UPDATED_DATE, 'YYYY-MM-DD HH24:MI:SS'));
  VALJSON.PUT('CREATED_BY',:OLD.CREATED_BY);
  VALJSON.PUT('CREATED_DATE',TO_CHAR(:OLD.CREATED_DATE, 'YYYY-MM-DD HH24:MI:SS'));
END IF;
  VALJSON.TO_CLOB(VALCLOB,FALSE,0,TRUE);
  INSERT INTO USER_LOG.LOG_ACTIONS (
    ID,
    LOG_DATE,
    LOG_TYPE,
    TABLE_NAME,
    JSON_VAL,
    STATUS,
    ACTION_TYPE,
    RECORD_ID
    ) VALUES (
        USER_LOG.SEQ_LOG_ACTIONS.NEXTVAL,
        SYSDATE,
        P_LOG_TYPE,
        'REF_ENGINE_MODEL',
        VALCLOB,
        1,
        1,
        P_RECORD_ID
    );
END;
/
ALTER TRIGGER "VRS"."TRL_REF_ENGINE_MODEL" ENABLE;
--------------------------------------------------------
--  DDL for Trigger TRL_REF_GENERAL
--------------------------------------------------------

  CREATE OR REPLACE EDITIONABLE TRIGGER "VRS"."TRL_REF_GENERAL" 
  AFTER INSERT OR UPDATE OR DELETE ON VRS.REF_GENERAL
  FOR EACH ROW
DECLARE
    VALJSON PLJSON;
    VALCLOB CLOB;
    P_RECORD_ID NUMBER;
    P_LOG_TYPE NUMBER;
BEGIN
  DBMS_LOB.CREATETEMPORARY(VALCLOB, TRUE);
  VALJSON:=PLJSON();
  
  P_RECORD_ID:=:NEW.ID;
  IF(INSERTING) THEN
    P_LOG_TYPE:=1;
  ELSIF(UPDATING) THEN
    P_LOG_TYPE:=2;
  ELSIF(DELETING) THEN
    P_LOG_TYPE:=3;
    P_RECORD_ID:=:OLD.ID;
  END IF;
IF(INSERTING OR UPDATING) THEN
  VALJSON.PUT('ID',:NEW.ID);
  VALJSON.PUT('REF_TYPE',:NEW.REF_TYPE);
  VALJSON.PUT('NAME',:NEW.NAME);
  VALJSON.PUT('CODE',:NEW.CODE);
  VALJSON.PUT('PARENT_ID',:NEW.PARENT_ID);
  VALJSON.PUT('STATUS',:NEW.STATUS);
  VALJSON.PUT('CREATED_BY',:NEW.CREATED_BY);
  VALJSON.PUT('CREATED_DATE',TO_CHAR(:NEW.CREATED_DATE, 'YYYY-MM-DD HH24:MI:SS'));
  VALJSON.PUT('UPDATED_BY',:NEW.UPDATED_BY);
  VALJSON.PUT('UPDATED_DATE',TO_CHAR(:NEW.UPDATED_DATE, 'YYYY-MM-DD HH24:MI:SS'));
  VALJSON.PUT('OLD_ID',:NEW.OLD_ID);
END IF;
IF(UPDATING OR DELETING) THEN
  VALJSON.PUT('ID',:OLD.ID);
  VALJSON.PUT('REF_TYPE',:OLD.REF_TYPE);
  VALJSON.PUT('NAME',:OLD.NAME);
  VALJSON.PUT('CODE',:OLD.CODE);
  VALJSON.PUT('PARENT_ID',:OLD.PARENT_ID);
  VALJSON.PUT('STATUS',:OLD.STATUS);
  VALJSON.PUT('CREATED_BY',:OLD.CREATED_BY);
  VALJSON.PUT('CREATED_DATE',TO_CHAR(:OLD.CREATED_DATE, 'YYYY-MM-DD HH24:MI:SS'));
  VALJSON.PUT('UPDATED_BY',:OLD.UPDATED_BY);
  VALJSON.PUT('UPDATED_DATE',TO_CHAR(:OLD.UPDATED_DATE, 'YYYY-MM-DD HH24:MI:SS'));
  VALJSON.PUT('OLD_ID',:OLD.OLD_ID);
END IF;
  VALJSON.TO_CLOB(VALCLOB,FALSE,0,TRUE);
  INSERT INTO USER_LOG.LOG_ACTIONS (
    ID,
    LOG_DATE,
    LOG_TYPE,
    TABLE_NAME,
    JSON_VAL,
    STATUS,
    ACTION_TYPE,
    RECORD_ID
    ) VALUES (
        USER_LOG.SEQ_LOG_ACTIONS.NEXTVAL,
        SYSDATE,
        P_LOG_TYPE,
        'REF_GENERAL',
        VALCLOB,
        1,
        1,
        P_RECORD_ID
    );
END;
/
ALTER TRIGGER "VRS"."TRL_REF_GENERAL" ENABLE;
--------------------------------------------------------
--  DDL for Trigger TRL_REF_GENERAL_TYPE
--------------------------------------------------------

  CREATE OR REPLACE EDITIONABLE TRIGGER "VRS"."TRL_REF_GENERAL_TYPE" 
  AFTER INSERT OR UPDATE OR DELETE ON VRS.REF_GENERAL_TYPE
  FOR EACH ROW
DECLARE
    VALJSON PLJSON;
    VALCLOB CLOB;
    P_RECORD_ID NUMBER;
    P_LOG_TYPE NUMBER;
BEGIN
  DBMS_LOB.CREATETEMPORARY(VALCLOB, TRUE);
  VALJSON:=PLJSON();
  
  P_RECORD_ID:=:NEW.ID;
  IF(INSERTING) THEN
    P_LOG_TYPE:=1;
  ELSIF(UPDATING) THEN
    P_LOG_TYPE:=2;
  ELSIF(DELETING) THEN
    P_LOG_TYPE:=3;
    P_RECORD_ID:=:OLD.ID;
  END IF;
IF(INSERTING OR UPDATING) THEN
  VALJSON.PUT('ID',:NEW.ID);
  VALJSON.PUT('NAME',:NEW.NAME);
  VALJSON.PUT('IS_EDIT',:NEW.IS_EDIT);
END IF;
IF(UPDATING OR DELETING) THEN
  VALJSON.PUT('ID',:OLD.ID);
  VALJSON.PUT('NAME',:OLD.NAME);
  VALJSON.PUT('IS_EDIT',:OLD.IS_EDIT);
END IF;
  VALJSON.TO_CLOB(VALCLOB,FALSE,0,TRUE);
  INSERT INTO USER_LOG.LOG_ACTIONS (
    ID,
    LOG_DATE,
    LOG_TYPE,
    TABLE_NAME,
    JSON_VAL,
    STATUS,
    ACTION_TYPE,
    RECORD_ID
    ) VALUES (
        USER_LOG.SEQ_LOG_ACTIONS.NEXTVAL,
        SYSDATE,
        P_LOG_TYPE,
        'REF_GENERAL_TYPE',
        VALCLOB,
        1,
        1,
        P_RECORD_ID
    );
END;
/
ALTER TRIGGER "VRS"."TRL_REF_GENERAL_TYPE" ENABLE;
--------------------------------------------------------
--  DDL for Trigger TRL_REF_PURPOSE
--------------------------------------------------------

  CREATE OR REPLACE EDITIONABLE TRIGGER "VRS"."TRL_REF_PURPOSE" 
  AFTER INSERT OR UPDATE OR DELETE ON VRS.REF_PURPOSE
  FOR EACH ROW
DECLARE
    VALJSON PLJSON;
    VALCLOB CLOB;
    P_RECORD_ID NUMBER;
    P_LOG_TYPE NUMBER;
BEGIN
  DBMS_LOB.CREATETEMPORARY(VALCLOB, TRUE);
  VALJSON:=PLJSON();
  
  P_RECORD_ID:=:NEW.ID;
  IF(INSERTING) THEN
    P_LOG_TYPE:=1;
  ELSIF(UPDATING) THEN
    P_LOG_TYPE:=2;
  ELSIF(DELETING) THEN
    P_LOG_TYPE:=3;
    P_RECORD_ID:=:OLD.ID;
  END IF;
IF(INSERTING OR UPDATING) THEN
  VALJSON.PUT('ID',:NEW.ID);
  VALJSON.PUT('NAME',:NEW.NAME);
  VALJSON.PUT('IS_VIN',:NEW.IS_VIN);
  VALJSON.PUT('PURPOSE_BASE_ID',:NEW.PURPOSE_BASE_ID);
  VALJSON.PUT('OLD_ID',:NEW.OLD_ID);
END IF;
IF(UPDATING OR DELETING) THEN
  VALJSON.PUT('ID',:OLD.ID);
  VALJSON.PUT('NAME',:OLD.NAME);
  VALJSON.PUT('IS_VIN',:OLD.IS_VIN);
  VALJSON.PUT('PURPOSE_BASE_ID',:OLD.PURPOSE_BASE_ID);
  VALJSON.PUT('OLD_ID',:OLD.OLD_ID);
END IF;
  VALJSON.TO_CLOB(VALCLOB,FALSE,0,TRUE);
  INSERT INTO USER_LOG.LOG_ACTIONS (
    ID,
    LOG_DATE,
    LOG_TYPE,
    TABLE_NAME,
    JSON_VAL,
    STATUS,
    ACTION_TYPE,
    RECORD_ID
    ) VALUES (
        USER_LOG.SEQ_LOG_ACTIONS.NEXTVAL,
        SYSDATE,
        P_LOG_TYPE,
        'REF_PURPOSE',
        VALCLOB,
        1,
        1,
        P_RECORD_ID
    );
END;
/
ALTER TRIGGER "VRS"."TRL_REF_PURPOSE" ENABLE;
--------------------------------------------------------
--  DDL for Trigger TRL_REG_MARK
--------------------------------------------------------

  CREATE OR REPLACE EDITIONABLE TRIGGER "VRS"."TRL_REG_MARK" 
  AFTER INSERT OR UPDATE OR DELETE ON VRS.REG_MARK
  FOR EACH ROW
DECLARE
    VALJSON PLJSON;
    VALCLOB CLOB;
    P_RECORD_ID NUMBER;
    P_LOG_TYPE NUMBER;
BEGIN
  DBMS_LOB.CREATETEMPORARY(VALCLOB, TRUE);
  VALJSON:=PLJSON();
  
  P_RECORD_ID:=:NEW.ID;
  IF(INSERTING) THEN
    P_LOG_TYPE:=1;
  ELSIF(UPDATING) THEN
    P_LOG_TYPE:=2;
  ELSIF(DELETING) THEN
    P_LOG_TYPE:=3;
    P_RECORD_ID:=:OLD.ID;
  END IF;
IF(INSERTING OR UPDATING) THEN
  VALJSON.PUT('ID',:NEW.ID);
  VALJSON.PUT('NAME',:NEW.NAME);
  VALJSON.PUT('COUNTRY_ID',:NEW.COUNTRY_ID);
  VALJSON.PUT('STATUS',:NEW.STATUS);
  VALJSON.PUT('CREATED_BY',:NEW.CREATED_BY);
  VALJSON.PUT('CREATED_DATE',TO_CHAR(:NEW.CREATED_DATE, 'YYYY-MM-DD HH24:MI:SS'));
  VALJSON.PUT('UPDATED_BY',:NEW.UPDATED_BY);
  VALJSON.PUT('UPDATED_DATE',TO_CHAR(:NEW.UPDATED_DATE, 'YYYY-MM-DD HH24:MI:SS'));
  VALJSON.PUT('OLD_ID',:NEW.OLD_ID);
END IF;
IF(UPDATING OR DELETING) THEN
  VALJSON.PUT('ID',:OLD.ID);
  VALJSON.PUT('NAME',:OLD.NAME);
  VALJSON.PUT('COUNTRY_ID',:OLD.COUNTRY_ID);
  VALJSON.PUT('STATUS',:OLD.STATUS);
  VALJSON.PUT('CREATED_BY',:OLD.CREATED_BY);
  VALJSON.PUT('CREATED_DATE',TO_CHAR(:OLD.CREATED_DATE, 'YYYY-MM-DD HH24:MI:SS'));
  VALJSON.PUT('UPDATED_BY',:OLD.UPDATED_BY);
  VALJSON.PUT('UPDATED_DATE',TO_CHAR(:OLD.UPDATED_DATE, 'YYYY-MM-DD HH24:MI:SS'));
  VALJSON.PUT('OLD_ID',:OLD.OLD_ID);
END IF;
  VALJSON.TO_CLOB(VALCLOB,FALSE,0,TRUE);
  INSERT INTO USER_LOG.LOG_ACTIONS (
    ID,
    LOG_DATE,
    LOG_TYPE,
    TABLE_NAME,
    JSON_VAL,
    STATUS,
    ACTION_TYPE,
    RECORD_ID
    ) VALUES (
        USER_LOG.SEQ_LOG_ACTIONS.NEXTVAL,
        SYSDATE,
        P_LOG_TYPE,
        'REG_MARK',
        VALCLOB,
        1,
        1,
        P_RECORD_ID
    );
END;
/
ALTER TRIGGER "VRS"."TRL_REG_MARK" ENABLE;
--------------------------------------------------------
--  DDL for Trigger TRL_REG_MODEL
--------------------------------------------------------

  CREATE OR REPLACE EDITIONABLE TRIGGER "VRS"."TRL_REG_MODEL" 
  AFTER INSERT OR UPDATE OR DELETE ON VRS."REG_MODEL"
  FOR EACH ROW
DECLARE
    VALJSON PLJSON;
    VALCLOB CLOB;
    P_RECORD_ID NUMBER;
    P_LOG_TYPE NUMBER;
BEGIN
  DBMS_LOB.CREATETEMPORARY(VALCLOB, TRUE);
  VALJSON:=PLJSON();
  
  P_RECORD_ID:=:NEW.ID;
  IF(INSERTING) THEN
    P_LOG_TYPE:=1;
  ELSIF(UPDATING) THEN
    P_LOG_TYPE:=2;
  ELSIF(DELETING) THEN
    P_LOG_TYPE:=3;
    P_RECORD_ID:=:OLD.ID;
  END IF;
IF(INSERTING OR UPDATING) THEN
  VALJSON.PUT('ID',:NEW.ID);
  VALJSON.PUT('NAME',:NEW.NAME);
  VALJSON.PUT('MARK_ID',:NEW.MARK_ID);
  VALJSON.PUT('STATUS',:NEW.STATUS);
  VALJSON.PUT('CREATED_BY',:NEW.CREATED_BY);
  VALJSON.PUT('CREATED_DATE',TO_CHAR(:NEW.CREATED_DATE, 'YYYY-MM-DD HH24:MI:SS'));
  VALJSON.PUT('UPDATED_BY',:NEW.UPDATED_BY);
  VALJSON.PUT('UPDATED_DATE',TO_CHAR(:NEW.UPDATED_DATE, 'YYYY-MM-DD HH24:MI:SS'));
  VALJSON.PUT('OLD_ID',:NEW.OLD_ID);
END IF;
IF(UPDATING OR DELETING) THEN
  VALJSON.PUT('ID',:OLD.ID);
  VALJSON.PUT('NAME',:OLD.NAME);
  VALJSON.PUT('MARK_ID',:OLD.MARK_ID);
  VALJSON.PUT('STATUS',:OLD.STATUS);
  VALJSON.PUT('CREATED_BY',:OLD.CREATED_BY);
  VALJSON.PUT('CREATED_DATE',TO_CHAR(:OLD.CREATED_DATE, 'YYYY-MM-DD HH24:MI:SS'));
  VALJSON.PUT('UPDATED_BY',:OLD.UPDATED_BY);
  VALJSON.PUT('UPDATED_DATE',TO_CHAR(:OLD.UPDATED_DATE, 'YYYY-MM-DD HH24:MI:SS'));
  VALJSON.PUT('OLD_ID',:OLD.OLD_ID);
END IF;
  VALJSON.TO_CLOB(VALCLOB,FALSE,0,TRUE);
  INSERT INTO USER_LOG.LOG_ACTIONS (
    ID,
    LOG_DATE,
    LOG_TYPE,
    TABLE_NAME,
    JSON_VAL,
    STATUS,
    ACTION_TYPE,
    RECORD_ID
    ) VALUES (
        USER_LOG.SEQ_LOG_ACTIONS.NEXTVAL,
        SYSDATE,
        P_LOG_TYPE,
        'REG_MODEL',
        VALCLOB,
        1,
        1,
        P_RECORD_ID
    );
END;
/
ALTER TRIGGER "VRS"."TRL_REG_MODEL" ENABLE;
--------------------------------------------------------
--  DDL for Trigger TRL_REG_MODIPICACE
--------------------------------------------------------

  CREATE OR REPLACE EDITIONABLE TRIGGER "VRS"."TRL_REG_MODIPICACE" 
  AFTER INSERT OR UPDATE OR DELETE ON VRS.REG_MODIPICACE
  FOR EACH ROW
DECLARE
    VALJSON PLJSON;
    VALCLOB CLOB;
    P_RECORD_ID NUMBER;
    P_LOG_TYPE NUMBER;
BEGIN
  DBMS_LOB.CREATETEMPORARY(VALCLOB, TRUE);
  VALJSON:=PLJSON();
  
  P_RECORD_ID:=:NEW.ID;
  IF(INSERTING) THEN
    P_LOG_TYPE:=1;
        --VRS.INSERT_LOG_UPDATED(:NEW.ID, 'I', 'REG_MODIPICACE');
  ELSIF(UPDATING) THEN
    P_LOG_TYPE:=2;
        --VRS.INSERT_LOG_UPDATED(:OLD.ID, 'U', 'REG_MODIPICACE');
  ELSIF(DELETING) THEN
    P_LOG_TYPE:=3;
    P_RECORD_ID:=:OLD.ID;
  END IF;
IF(INSERTING OR UPDATING) THEN
  VALJSON.PUT('ID',:NEW.ID);
  VALJSON.PUT('VIN_NO',:NEW.VIN_NO);
  VALJSON.PUT('MODEL_ID',:NEW.MODEL_ID);
  VALJSON.PUT('VEHICLE_TYPE_ID',:NEW.VEHICLE_TYPE_ID);
  VALJSON.PUT('CLASSIFICATION_ID',:NEW.CLASSIFICATION_ID);
  VALJSON.PUT('AXLE_COUNT',:NEW.AXLE_COUNT);
  VALJSON.PUT('TOTAL_WEIGHT',:NEW.TOTAL_WEIGHT);
  VALJSON.PUT('SEAT_COUNT',:NEW.SEAT_COUNT);
  VALJSON.PUT('DOOR_COUNT',:NEW.DOOR_COUNT);
  VALJSON.PUT('MAX_LOAD',:NEW.MAX_LOAD);
  VALJSON.PUT('OWN_WEIGHT',:NEW.OWN_WEIGHT);
  VALJSON.PUT('HEIGHT',:NEW.HEIGHT);
  VALJSON.PUT('WIDTH',:NEW.WIDTH);
  VALJSON.PUT('LENGTH',:NEW.LENGTH);
  VALJSON.PUT('MODIFICACE_NAME',:NEW.MODIFICACE_NAME);
  VALJSON.PUT('STATUS',:NEW.STATUS);
  VALJSON.PUT('CREATED_BY',:NEW.CREATED_BY);
  VALJSON.PUT('CREATED_DATE',TO_CHAR(:NEW.CREATED_DATE, 'YYYY-MM-DD HH24:MI:SS'));
  VALJSON.PUT('UPDATED_BY',:NEW.UPDATED_BY);
  VALJSON.PUT('UPDATED_DATE',TO_CHAR(:NEW.UPDATED_DATE, 'YYYY-MM-DD HH24:MI:SS'));
  VALJSON.PUT('IS_HYBRID',:NEW.IS_HYBRID);
  VALJSON.PUT('ENGINE_MODEL_ID',:NEW.ENGINE_MODEL_ID);
END IF;
IF(UPDATING OR DELETING) THEN
  VALJSON.PUT('ID',:OLD.ID);
  VALJSON.PUT('VIN_NO',:OLD.VIN_NO);
  VALJSON.PUT('MODEL_ID',:OLD.MODEL_ID);
  VALJSON.PUT('VEHICLE_TYPE_ID',:OLD.VEHICLE_TYPE_ID);
  VALJSON.PUT('CLASSIFICATION_ID',:OLD.CLASSIFICATION_ID);
  VALJSON.PUT('AXLE_COUNT',:OLD.AXLE_COUNT);
  VALJSON.PUT('TOTAL_WEIGHT',:OLD.TOTAL_WEIGHT);
  VALJSON.PUT('SEAT_COUNT',:OLD.SEAT_COUNT);
  VALJSON.PUT('DOOR_COUNT',:OLD.DOOR_COUNT);
  VALJSON.PUT('MAX_LOAD',:OLD.MAX_LOAD);
  VALJSON.PUT('OWN_WEIGHT',:OLD.OWN_WEIGHT);
  VALJSON.PUT('HEIGHT',:OLD.HEIGHT);
  VALJSON.PUT('WIDTH',:OLD.WIDTH);
  VALJSON.PUT('LENGTH',:OLD.LENGTH);
  VALJSON.PUT('MODIFICACE_NAME',:OLD.MODIFICACE_NAME);
  VALJSON.PUT('STATUS',:OLD.STATUS);
  VALJSON.PUT('CREATED_BY',:OLD.CREATED_BY);
  VALJSON.PUT('CREATED_DATE',TO_CHAR(:OLD.CREATED_DATE, 'YYYY-MM-DD HH24:MI:SS'));
  VALJSON.PUT('UPDATED_BY',:OLD.UPDATED_BY);
  VALJSON.PUT('UPDATED_DATE',TO_CHAR(:OLD.UPDATED_DATE, 'YYYY-MM-DD HH24:MI:SS'));
  VALJSON.PUT('IS_HYBRID',:OLD.IS_HYBRID);
  VALJSON.PUT('ENGINE_MODEL_ID',:NEW.ENGINE_MODEL_ID);
END IF;
  VALJSON.TO_CLOB(VALCLOB,FALSE,0,TRUE);
  INSERT INTO USER_LOG.LOG_ACTIONS (
    ID,
    LOG_DATE,
    LOG_TYPE,
    TABLE_NAME,
    JSON_VAL,
    STATUS,
    ACTION_TYPE,
    RECORD_ID
    ) VALUES (
        USER_LOG.SEQ_LOG_ACTIONS.NEXTVAL,
        SYSDATE,
        P_LOG_TYPE,
        'REG_MODIPICACE',
        VALCLOB,
        1,
        1,
        P_RECORD_ID
    );
END;
/
ALTER TRIGGER "VRS"."TRL_REG_MODIPICACE" ENABLE;
--------------------------------------------------------
--  DDL for Trigger TRL_REG_VEHICLE
--------------------------------------------------------

  CREATE OR REPLACE EDITIONABLE TRIGGER "VRS"."TRL_REG_VEHICLE" 
AFTER INSERT OR UPDATE OF CABIN_NO,MODEL_ID,COLOR_ID,SPECIAL_ID,BUILD_YEAR,IMPORT_DATE,EXHAUST_NO--,PLATE_NO,OWNER_ID,STATUS  
ON VRS.REG_VEHICLE
FOR EACH ROW
    DECLARE
        P_PURPOSE_NAME VARCHAR2(200); 
        P_WEIGHT VARCHAR2(200);
        P_BODY_SIZE VARCHAR2(200); 
        P_ASD_COUNT VARCHAR2(200);
        P_COLOR_NAME VARCHAR2(100); 
        P_ENGINE_MODEL_NAME VARCHAR2(200);
        P_SPCIAL_NAME VARCHAR2(100);
        P_CREATED_NAME VARCHAR2(100); 
        P_BRANCH_NAME VARCHAR2(100); 
        P_IS_UPDATE NUMBER:=0;
        P_SERVICE_ID NUMBER:=23;
        P_IS_LOG NUMBER:=0;
BEGIN
            
IF INSERTING THEN
 --//////////////////////////////////////////////////////////////////////////////////
            select  (PURPOSE_NAME||', '||VEHICLE_TYPE_NAME||', '||VIN_NO),
                    (OWN_WEIGHT||'+'||MAX_LOAD||'='||TOTAL_WEIGHT), 
                    ('L'||LENGTH||'xH'||HEIGHT||'xW'||WIDTH), 
                    ('A'||AXLE_COUNT||', S'||SEAT_COUNT||', D'||DOOR_COUNT),
                    (EM_NAME||', '||FT_NAME||', '||CAPACITY||'cc')
            INTO P_PURPOSE_NAME,P_WEIGHT,P_BODY_SIZE,P_ASD_COUNT,P_ENGINE_MODEL_NAME
            from VRS.reg_modipicace_view WHERE ROWNUM=1 AND id=:NEW.MODEL_ID;
--//////////////////////////////////////////////////////////////////////////////////              
            select "NAME" INTO P_COLOR_NAME from VRS.REF_COLOR where ROWNUM=1 AND id=:NEW.COLOR_ID; 
--//////////////////////////////////////////////////////////////////////////////////              
            IF :NEW.SPECIAL_ID IS NOT NULL THEN
                select "NAME" INTO p_spcial_name from vrs.ref_general where ROWNUM=1 AND REF_TYPE=8 AND id=:NEW.SPECIAL_ID;
            END IF;
 --//////////////////////////////////////////////////////////////////////////////////            
            select BRANCH_NAME,FULLNAME 
            INTO P_BRANCH_NAME, P_CREATED_NAME 
            from MVIS.sys_user_view where ROWNUM=1 AND id=:NEW.INS_CREATED_BY;
          

	INSERT INTO VRS.REG_VEHICLE_INSP_ARCHIVE
	(
            ID, 
            VEHICLE_ID, 
            CABIN_NO, 
            DECLARATION_NO, 
            BUILD_YEAR, 
            IMPORT_DATE, 
            MODEL_ID, 
            PURPOSE_NAME,
            WEIGHT, 
            BODY_SIZE, 
            ASD_COUNT, 
            COLOR_NAME, 
            ENGINE_MODEL_NAME, 
            BRANCH_NAME, 
            CREATED_BY, 
            CREATED_NAME, 
            CREATED_DATE,
            SERVICE_ID,
            SPECIAL_NAME,
            EXHAUST_NO
	)
	VALUES
	(
			VRS.SEQ_REG_VEHICLE_INSP_ARCHIVE.NEXTVAL,
			:NEW.ID,
			:NEW.CABIN_NO,
			:NEW.DECLARATION_NO,
 			:NEW.BUILD_YEAR,
 			:NEW.IMPORT_DATE,
 			:NEW.MODEL_ID,
            P_PURPOSE_NAME,
            P_WEIGHT, 
            P_BODY_SIZE, 
            P_ASD_COUNT, 
            P_COLOR_NAME, 
            P_ENGINE_MODEL_NAME, 
            P_BRANCH_NAME,
 			:NEW.INS_CREATED_BY,
            P_CREATED_NAME,
			--:NEW.INS_CREATED_DATE,
            SYSDATE,
            P_SERVICE_ID,
            p_spcial_name,
            :NEW.EXHAUST_NO
	);

    --VRS.INSERT_LOG_UPDATED(:NEW.ID, 'I', 'REG_VEHICLE');
--//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////    
ELSIF UPDATING THEN
--//////////////////////////////////////////////////////////////////////////////////  
        IF :OLD.PLATE_NO!=:NEW.PLATE_NO OR :OLD.OWNER_ID!=:NEW.OWNER_ID THEN 
            P_IS_LOG:=1;
        END IF;
--//////////////////////////////////////////////////////////////////////////////////         
        IF :OLD.STATUS!=:NEW.STATUS THEN
            IF :NEW.STATUS=9 THEN
                P_IS_LOG:=1;
            END IF;
        END IF;
--////////////////////////////////////////////////////////////////////////////////// 
        IF :OLD.SPECIAL_ID IS NOT NULL AND :OLD.SPECIAL_ID!=:NEW.SPECIAL_ID THEN        
            select "NAME" INTO p_spcial_name from vrs.ref_general where ROWNUM=1 AND REF_TYPE=8 AND id=:OLD.SPECIAL_ID;
            P_IS_UPDATE:=1;
            P_SERVICE_ID:=24;
        END IF;
--//////////////////////////////////////////////////////////////////////////////////
        IF :OLD.MODEL_ID!=:NEW.MODEL_ID THEN        
            select  (PURPOSE_NAME||', '||VEHICLE_TYPE_NAME||', '||VIN_NO),
                    (OWN_WEIGHT||'+'||MAX_LOAD||'='||TOTAL_WEIGHT), 
                    ('L'||LENGTH||'xH'||HEIGHT||'xW'||WIDTH),
                    ('A'||AXLE_COUNT||', S'||SEAT_COUNT||', D'||DOOR_COUNT),
                    (EM_NAME||', '||FT_NAME||', '||CAPACITY||'cc')
            INTO P_PURPOSE_NAME,P_WEIGHT,P_BODY_SIZE,P_ASD_COUNT,P_ENGINE_MODEL_NAME
                    from VRS.reg_modipicace_view WHERE ROWNUM=1 AND id=:OLD.MODEL_ID;
            P_IS_UPDATE:=1;
            P_IS_LOG:=1;
            P_SERVICE_ID:=20;
        END IF;     
 --//////////////////////////////////////////////////////////////////////////////////       
        IF :OLD.COLOR_ID IS NOT NULL THEN
            IF :OLD.COLOR_ID!=:NEW.COLOR_ID THEN
                select "NAME" INTO P_COLOR_NAME from VRS.REF_COLOR where ROWNUM=1 AND id=:OLD.COLOR_ID;
                P_IS_UPDATE:=1;
                P_SERVICE_ID:=22;
            END IF;
        END IF;
--//////////////////////////////////////////////////////////////////////////////////
        IF :OLD.CABIN_NO!=:NEW.CABIN_NO THEN
            P_IS_UPDATE:=1;
            P_IS_LOG:=1;
            P_SERVICE_ID:=21;
        END IF;
--//////////////////////////////////////////////////////////////////////////////////
        IF (:OLD.EXHAUST_NO IS NULL AND :NEW.EXHAUST_NO IS NOT NULL) OR (:OLD.EXHAUST_NO!=:NEW.EXHAUST_NO) THEN
            P_SERVICE_ID:=25;
            P_IS_UPDATE:=1;
        END IF;
--//////////////////////////////////////////////////////////////////////////////////         
        IF :NEW.INS_UPDATED_BY IS NOT NULL THEN
                select BRANCH_NAME,FULLNAME 
            INTO P_BRANCH_NAME, P_CREATED_NAME 
                from MVIS.sys_user_view where ROWNUM=1 AND id=:NEW.INS_UPDATED_BY;
        END IF;    
--//////////////////////////////////////////////////////////////////////////////////      
        IF :NEW.BUILD_YEAR!=:OLD.BUILD_YEAR OR TO_DATE(:NEW.IMPORT_DATE)!=TO_DATE(:OLD.IMPORT_DATE) THEN
            P_BRANCH_NAME:=NULL;
            P_CREATED_NAME:=NULL;
            P_IS_UPDATE:=1;
            P_SERVICE_ID:=8;
            --:NEW.INS_UPDATED_BY:=NULL;
        END IF;
--//////////////////////////////////////////////////////////////////////////////////   

    IF P_IS_UPDATE=1 THEN
        INSERT INTO VRS.REG_VEHICLE_INSP_ARCHIVE
        (
                ID, 
                VEHICLE_ID,
                PLATE_NO,
                CABIN_NO, 
                DECLARATION_NO, 
                BUILD_YEAR, 
                IMPORT_DATE, 
                MODEL_ID, 
                PURPOSE_NAME,
                WEIGHT, 
                BODY_SIZE, 
                ASD_COUNT, 
                COLOR_NAME, 
                ENGINE_MODEL_NAME, 
                BRANCH_NAME, 
                CREATED_BY, 
                CREATED_NAME, 
                CREATED_DATE,
                SERVICE_ID,
                SPECIAL_NAME,
                EXHAUST_NO
        )
        VALUES
        (
                VRS.SEQ_REG_VEHICLE_INSP_ARCHIVE.NEXTVAL,
                :OLD.ID,
                :OLD.PLATE_NO,
                :OLD.CABIN_NO,
                :OLD.DECLARATION_NO,
                :OLD.BUILD_YEAR,
                :OLD.IMPORT_DATE,
                :OLD.MODEL_ID,
                P_PURPOSE_NAME,
                P_WEIGHT, 
                P_BODY_SIZE, 
                P_ASD_COUNT, 
                P_COLOR_NAME, 
                P_ENGINE_MODEL_NAME, 
                P_BRANCH_NAME,
                --:NEW.INS_UPDATED_BY,
                (CASE WHEN P_BRANCH_NAME IS NOT NULL THEN :NEW.INS_UPDATED_BY ELSE NULL END),
                P_CREATED_NAME,
                --:NEW.INS_UPDATED_DATE,
                SYSDATE,
                P_SERVICE_ID,
                p_spcial_name,
                :NEW.EXHAUST_NO
        );
    END IF;
    
--    IF P_IS_LOG=1 THEN
--        VRS.INSERT_LOG_UPDATED(:OLD.ID, 'U', 'REG_VEHICLE');    
--    END IF;
    
END IF;
END;
/
ALTER TRIGGER "VRS"."TRL_REG_VEHICLE" ENABLE;
--------------------------------------------------------
--  DDL for Trigger TRL_REG_VEHICLE_BEFORE
--------------------------------------------------------

  CREATE OR REPLACE EDITIONABLE TRIGGER "VRS"."TRL_REG_VEHICLE_BEFORE" 
BEFORE UPDATE OF SPECIAL_ID ON VRS.REG_VEHICLE
FOR EACH ROW
BEGIN
    IF :OLD.SPECIAL_ID IS NOT NULL AND :NEW.SPECIAL_ID = -1 THEN
        :NEW.SPECIAL_ID := NULL; -- шууд шинэ мөрийн утгыг өөрчилнө
    END IF;
END;
/
ALTER TRIGGER "VRS"."TRL_REG_VEHICLE_BEFORE" ENABLE;
--------------------------------------------------------
--  DDL for Trigger TRL_REG_VEHICLE_TYPE
--------------------------------------------------------

  CREATE OR REPLACE EDITIONABLE TRIGGER "VRS"."TRL_REG_VEHICLE_TYPE" 
  AFTER INSERT OR UPDATE OR DELETE ON VRS.REG_VEHICLE_TYPE
  FOR EACH ROW
DECLARE
    VALJSON PLJSON;
    VALCLOB CLOB;
    P_RECORD_ID NUMBER;
    P_LOG_TYPE NUMBER;
BEGIN
  DBMS_LOB.CREATETEMPORARY(VALCLOB, TRUE);
  VALJSON:=PLJSON();
  
  P_RECORD_ID:=:NEW.ID;
  IF(INSERTING) THEN
    P_LOG_TYPE:=1;
  ELSIF(UPDATING) THEN
    P_LOG_TYPE:=2;
  ELSIF(DELETING) THEN
    P_LOG_TYPE:=3;
    P_RECORD_ID:=:OLD.ID;
  END IF;
IF(INSERTING OR UPDATING) THEN
  VALJSON.PUT('ID',:NEW.ID);
  VALJSON.PUT('NAME',:NEW.NAME);
  VALJSON.PUT('DECELERATION',:NEW.DECELERATION);
  VALJSON.PUT('TREADDEPTH',:NEW.TREADDEPTH);
  VALJSON.PUT('FREEOPERATION',:NEW.FREEOPERATION);
  VALJSON.PUT('STATUS',:NEW.STATUS);
  VALJSON.PUT('CREATED_BY',:NEW.CREATED_BY);
  VALJSON.PUT('CREATED_DATE',TO_CHAR(:NEW.CREATED_DATE, 'YYYY-MM-DD HH24:MI:SS'));
  VALJSON.PUT('UPDATED_BY',:NEW.UPDATED_BY);
  VALJSON.PUT('UPDATED_DATE',TO_CHAR(:NEW.UPDATED_DATE, 'YYYY-MM-DD HH24:MI:SS'));
  VALJSON.PUT('PURPOSE_ID',:NEW.PURPOSE_ID);
  VALJSON.PUT('OLD_ID',:NEW.OLD_ID);
END IF;
IF(UPDATING OR DELETING) THEN
  VALJSON.PUT('ID',:OLD.ID);
  VALJSON.PUT('NAME',:OLD.NAME);
  VALJSON.PUT('DECELERATION',:OLD.DECELERATION);
  VALJSON.PUT('TREADDEPTH',:OLD.TREADDEPTH);
  VALJSON.PUT('FREEOPERATION',:OLD.FREEOPERATION);
  VALJSON.PUT('STATUS',:OLD.STATUS);
  VALJSON.PUT('CREATED_BY',:OLD.CREATED_BY);
  VALJSON.PUT('CREATED_DATE',TO_CHAR(:OLD.CREATED_DATE, 'YYYY-MM-DD HH24:MI:SS'));
  VALJSON.PUT('UPDATED_BY',:OLD.UPDATED_BY);
  VALJSON.PUT('UPDATED_DATE',TO_CHAR(:OLD.UPDATED_DATE, 'YYYY-MM-DD HH24:MI:SS'));
  VALJSON.PUT('PURPOSE_ID',:OLD.PURPOSE_ID);
  VALJSON.PUT('OLD_ID',:OLD.OLD_ID);
END IF;
  VALJSON.TO_CLOB(VALCLOB,FALSE,0,TRUE);
  INSERT INTO USER_LOG.LOG_ACTIONS (
    ID,
    LOG_DATE,
    LOG_TYPE,
    TABLE_NAME,
    JSON_VAL,
    STATUS,
    ACTION_TYPE,
    RECORD_ID
    ) VALUES (
        USER_LOG.SEQ_LOG_ACTIONS.NEXTVAL,
        SYSDATE,
        P_LOG_TYPE,
        'REG_VEHICLE_TYPE',
        VALCLOB,
        1,
        1,
        P_RECORD_ID
    );
END;
/
ALTER TRIGGER "VRS"."TRL_REG_VEHICLE_TYPE" ENABLE;
--------------------------------------------------------
--  DDL for Trigger VEHICLE_TYPE_TRG
--------------------------------------------------------

  CREATE OR REPLACE EDITIONABLE TRIGGER "VRS"."VEHICLE_TYPE_TRG" 
BEFORE INSERT ON VEHICLE_TYPE 
FOR EACH ROW 
BEGIN
  <<COLUMN_SEQUENCES>>
  BEGIN
    IF INSERTING AND :NEW.ID IS NULL THEN
      SELECT VEHICLE_TYPE_SEQ.NEXTVAL INTO :NEW.ID FROM SYS.DUAL;
    END IF;
  END COLUMN_SEQUENCES;
END;







/
ALTER TRIGGER "VRS"."VEHICLE_TYPE_TRG" ENABLE;
--------------------------------------------------------
--  DDL for Procedure ARCHIVE_NUMBER_PROCEDURE
--------------------------------------------------------
set define off;

  CREATE OR REPLACE EDITIONABLE PROCEDURE "VRS"."ARCHIVE_NUMBER_PROCEDURE" AS 
BEGIN
    DECLARE CURSOR all_archive IS SELECT * FROM SYSTEM_ARCHIVE WHERE DELETED_AT IS NULL;
    v_count NUMBER := 0; 
    BEGIN
        FOR x in all_archive
        LOOP
            SELECT COUNT(*) INTO v_count FROM ARCHIVE_NUMBER WHERE ABBR = x.ABBR AND ARCHIVE_DEPARTMENT_ID = x.DEPARTMENTID AND YEAR = TO_CHAR(sysdate, ('YYYY')) AND MONTH = TO_CHAR(sysdate, ('MM'));
            IF v_count < 1 THEN
               INSERT INTO ARCHIVE_NUMBER 
                (ARCHIVE_DEPARTMENT_ID, YEAR, MONTH, ABBR, NEW_COUNT,DELETE_COUNT, OTHER_COUNT, CREATEDDATE, UPDATEDDATE, CREATEDBY, MODIFIEDBY) 
                VALUES (x.DEPARTMENTID, to_char(sysdate, ('YYYY')), to_char(sysdate, ('MM')), x.ABBR, 0, 0, 0, sysdate, sysdate, x.CREATEDBY, x.MODIFIEDBY);
            END IF;
            v_count := 0;
        END LOOP;
    END;
END ARCHIVE_NUMBER_PROCEDURE;

/
--------------------------------------------------------
--  DDL for Procedure INSERT_LOG_UPDATED
--------------------------------------------------------
set define off;

  CREATE OR REPLACE EDITIONABLE PROCEDURE "VRS"."INSERT_LOG_UPDATED" 
(
  REF_ID IN NUMBER 
, ACTION IN VARCHAR2 
, TABLE_NAME IN VARCHAR2 
) AS 
BEGIN
  --//////////////////////////////////////////////////////////////////////////////////    
    	INSERT INTO VRS.LOG_UPDATED
        (
            ID, 
            REF_ID, 
            ACTION,
            TABLE_NAME, 
            UPDATED_DATE
        )
    	VALUES
        (
			VRS.LOG_UPDATED_SEQ.NEXTVAL,
			REF_ID,
            ACTION,
            TABLE_NAME,
            SYSDATE
        );
--////////////////////////////////////////////////////////////////////////////////// 
END INSERT_LOG_UPDATED;

/
--------------------------------------------------------
--  DDL for Procedure REG_NEW_TOVYO
--------------------------------------------------------
set define off;

  CREATE OR REPLACE EDITIONABLE PROCEDURE "VRS"."REG_NEW_TOVYO" 
(   @Archive_number		VARCHAR2(5),
	@StartNumber		INT,
	@EndNumber			INT
)
AS
BEGIN
	CREATE TABLE #TmpTovyo
	(
		number			VARCHAR(7),
		InvDate			VARCHAR(23),
		Comment			VARCHAR(150),
		PageNumber		VARCHAR(10),
		[Index]			VARCHAR(10),
		[PageCount]		INT
	)
	DECLARE @SArchiveNumber	NVARCHAR(23),
			@EArchiveNumber	NVARCHAR(23),
			@Type			NVARCHAR(2)
	SET @SArchiveNumber = @Archive+CONVERT(NVARCHAR(23),@StartNumber)
	SET @EArchiveNumber = @Archive+CONVERT(NVARCHAR(23),@EndNumber)
	SET @Type = LEFT(@Archive,2)

	--SELECT @SArchiveNumber,@EArchiveNumber
	IF @Type = u'\0428\0425'
	BEGIN
		SELECT ARCHIVE_NUMBER INTO #Shiljilt FROM ARCHIVE 
			WHERE ARCHIVE_NUMBER BETWEEN @SArchiveNumber AND @EArchiveNumber 
					GROUP BY ARCHIVE_NUMBER

		SELECT A.VEHICLE_ID,A.ARCHIVE_NUMBER INTO #TmpSH
			FROM ARCHIVE A WITH(NOLOCK)
				INNER JOIN #Shiljilt B ON A.ARCHIVE_NUMBER = B.ARCHIVE_NUMBER
		------------------mashini medeelel tsugluulj bga------------------	
		INSERT INTO #TmpTovyo
			SELECT A.PLATE_NO,A.CABIN_NO,T.ARCHIVE_NUMBER,CONVERT(NVARCHAR(23),CONVERT(DATETIME,A.REGISTER_DATE),111),'','','',A.PAGE_COUNT
				FROM REG_VEHICLE A WITH(NOLOCK)
				INNER JOIN #TmpSH T ON A.ID = T.VEHICLE_ID
		------------------------------------------------------------------
	END
	ELSE
	BEGIN
		INSERT INTO #TmpTovyo
			 A.PLATE_NO,A.CABIN_NO,T.ARCHIVE_NUMBER,CONVERT(NVARCHAR(23),CONVERT(DATETIME,A.REGISTER_DATE),111),'','','',A.PAGE_COUNT
				FROM REG_VEHICLE A WITH(NOLOCK)
							WHERE FIRST_ARCHIVE_NO BETWEEN @SArchiveNumber AND @EArchiveNumber

		END
--PRINT @SArchiveNumber
--RETURN
	SELECT ROW_NUMBER() OVER (ORDER BY first_archive) AS Row,* FROM #TmpTovyo ORDER BY first_archive
END REG_New_Tovyo

/
--------------------------------------------------------
--  DDL for Function CHECK_PLATE_NUMBER_SAVE
--------------------------------------------------------

  CREATE OR REPLACE EDITIONABLE FUNCTION "VRS"."CHECK_PLATE_NUMBER_SAVE" (    
    PLATE_NO NVARCHAR2, 
    REGISTER_NO NVARCHAR2
)
RETURN VARCHAR2 AS
    v_vehicle_exists  NUMBER := 0;
    v_order_exists    NUMBER := 0;
    v_save_exists     NUMBER := 0;
    saved_reg         VARCHAR2(100);
BEGIN
    -- ТХ мөн үү?    
    SELECT CASE 
             WHEN EXISTS (
                 SELECT 1 
                 FROM VRS.REG_VEHICLE_VIEW  
                 WHERE PLATE_NO = CHECK_PLATE_NUMBER_SAVE.PLATE_NO 
                   AND REGISTER_NO = CHECK_PLATE_NUMBER_SAVE.REGISTER_NO
             ) 
             THEN 1 
             ELSE 0 
           END
    INTO v_vehicle_exists
    FROM dual;

    IF v_vehicle_exists = 0 THEN
        RETURN 'ТХ-ийн дугаар, өмчлөгчийн регистр тохирохгүй байна';
    END IF;

    -- Захиалга байна уу?
    SELECT CASE 
             WHEN EXISTS (
                 SELECT 1 
                 FROM VRS.SERIES_NUMBER  
                 WHERE NAME = CHECK_PLATE_NUMBER_SAVE.PLATE_NO 
                   AND IS_ORDER = 1
             ) 
             THEN 1 
             ELSE 0 
           END
    INTO v_order_exists
    FROM dual;


    IF v_order_exists = 1 THEN
        RETURN 'Дугаар захиалагдсан байна';
    END IF;

    -- Хадгалсан байна уу?
    SELECT CASE 
             WHEN EXISTS (
                 SELECT 1 
                 FROM VRS.REG_PLATENUMBER_SAVE  
                 WHERE PLATE_NO = CHECK_PLATE_NUMBER_SAVE.PLATE_NO 
                   AND IS_ACTIVE = 1
             ) 
             THEN 1 
             ELSE 0 
           END
    INTO v_save_exists
    FROM dual;

    IF v_save_exists = 1 THEN
        SELECT CUSTOMER_REGNUM 
            INTO saved_reg
        FROM VRS.REG_PLATENUMBER_SAVE  
            WHERE PLATE_NO = CHECK_PLATE_NUMBER_SAVE.PLATE_NO AND IS_ACTIVE = 1;
            
        RETURN 'Дугаар хадгалагдсан байна' ||' - '||saved_reg;
    END IF;

    -- Хариу үүсгэх
    RETURN  'Хадгалах боломжтой.';

EXCEPTION
    WHEN OTHERS THEN
        RETURN 'ERROR: ' || SQLERRM;
END;

/
--------------------------------------------------------
--  DDL for Function GENERATE_ARCHIVE_NUMBER
--------------------------------------------------------

  CREATE OR REPLACE EDITIONABLE FUNCTION "VRS"."GENERATE_ARCHIVE_NUMBER" (
    P_SERVICE_PREFIX     IN VARCHAR2,
    P_ARCHIVE_DEPT_ID    IN NUMBER,
    P_ARCHIVE_DEPT_ABBR  IN VARCHAR2,
    P_USER_ID            IN NUMBER
) RETURN VARCHAR2 IS
    V_CURRENT_YEAR  NUMBER := TO_NUMBER(TO_CHAR(SYSDATE, 'YYYY'));
    V_CURRENT_MONTH NUMBER := TO_NUMBER(TO_CHAR(SYSDATE, 'MM'));
    V_UPDATE_COUNT  NUMBER := 0;
    V_GENERATED_NO  VARCHAR2(100);
    V_PREFIX        VARCHAR2(10) := P_SERVICE_PREFIX;
BEGIN
    FOR REC IN (
        SELECT *
        FROM VRS.ARCHIVE_NUMBER
        WHERE ABBR = P_ARCHIVE_DEPT_ABBR
          AND ARCHIVE_DEPARTMENT_ID = P_ARCHIVE_DEPT_ID
          AND YEAR = V_CURRENT_YEAR
          AND MONTH = V_CURRENT_MONTH
        FOR UPDATE
    )
    LOOP
        IF V_PREFIX = 'ШХ' THEN
            UPDATE VRS.ARCHIVE_NUMBER
            SET OTHER_COUNT = OTHER_COUNT + 1,
                MODIFIEDBY = P_USER_ID
            WHERE ABBR = P_ARCHIVE_DEPT_ABBR
              AND ARCHIVE_DEPARTMENT_ID = P_ARCHIVE_DEPT_ID
              AND YEAR = V_CURRENT_YEAR
              AND MONTH = V_CURRENT_MONTH;
            V_UPDATE_COUNT := REC.OTHER_COUNT + 1;
        END IF;
        
        IF V_PREFIX = 'ДХ' THEN
            UPDATE VRS.ARCHIVE_NUMBER
            SET PLATE_SAVE_COUNT = PLATE_SAVE_COUNT + 1,
                MODIFIEDBY = P_USER_ID
            WHERE ABBR = P_ARCHIVE_DEPT_ABBR
              AND ARCHIVE_DEPARTMENT_ID = P_ARCHIVE_DEPT_ID
              AND YEAR = V_CURRENT_YEAR
              AND MONTH = V_CURRENT_MONTH;
            V_UPDATE_COUNT := REC.PLATE_SAVE_COUNT + 1;
        END IF;
    END LOOP;

    V_GENERATED_NO := LPAD(V_UPDATE_COUNT, 6, '0');
    RETURN V_PREFIX || P_ARCHIVE_DEPT_ABBR || TO_CHAR(SYSDATE, 'YYMM') || V_GENERATED_NO;

EXCEPTION
    WHEN OTHERS THEN
        -- optionally: write to a log table
        RETURN 'ERROR';
END;

/

  GRANT EXECUTE ON "VRS"."GENERATE_ARCHIVE_NUMBER" TO "USER_EMONGOL";
--------------------------------------------------------
--  DDL for Function GET_PREV_NUMBER
--------------------------------------------------------

  CREATE OR REPLACE EDITIONABLE FUNCTION "VRS"."GET_PREV_NUMBER" 
(
  V_ID IN NUMBER 
) RETURN VARCHAR2 AS prev_plate_no VARCHAR2(1000);
BEGIN
SELECT plate_no into prev_plate_no FROM (
    --select * from vrs.reg_vehicle_archive where vehicle_id=VEHICLE_ID  
    SELECT LISTAGG(plate_no, ', ') WITHIN GROUP (ORDER BY null) plate_no
    FROM (SELECT DISTINCT plate_no FROM vrs.reg_vehicle_archive where vehicle_id=V_ID AND plate_no IS NOT NULL ORDER BY id)
);
 return prev_plate_no;
END;

/
--------------------------------------------------------
--  DDL for Function INSERT_TO_ARCHIVE_TEXT
--------------------------------------------------------

  CREATE OR REPLACE EDITIONABLE FUNCTION "VRS"."INSERT_TO_ARCHIVE_TEXT" 
(
  S_TYPE IN NUMBER 
, S_ID IN NUMBER 
) RETURN SYS_REFCURSOR IS l_rc SYS_REFCURSOR; 
BEGIN
    IF S_TYPE=1 THEN
        OPEN l_rc
        FOR             select (PURPOSE_NAME||', '||VEHICLE_TYPE_NAME||', '||VIN_NO),
        (OWN_WEIGHT||'+'||MAX_LOAD||'='||TOTAL_WEIGHT), 
        ('L'||LENGTH||'xH'||HEIGHT||'xW'||WIDTH),
        ('A'||AXLE_COUNT||', S'||SEAT_COUNT||', D'||DOOR_COUNT)
        from VRS.reg_modipicace_view
        where ROWNUM=1 AND id=S_ID;  
    ELSIF  S_TYPE=2 THEN
        OPEN l_rc
        FOR             select NAME
        from VRS.REF_COLOR
        where ROWNUM=1 AND id=S_ID; 
    ELSIF  S_TYPE=3 THEN
        OPEN l_rc
        FOR             SELECT (NAME||', '||FUEL_TYPE_NAME||', '||ENGINE_CAPACITY||'cc') 
        FROM VRS.REF_ENGINE_MODEL_VIEW
        where ROWNUM=1 AND id=S_ID;     
    ELSIF  S_TYPE=4 THEN
        OPEN l_rc
        FOR             select BRANCH_NAME,FULLNAME
        from MVIS.sys_user_view
        where ROWNUM=1 AND id=S_ID;  
  END IF; 
      RETURN (l_rc);
END;

/
--------------------------------------------------------
--  DDL for Synonymn JSON
--------------------------------------------------------

  CREATE OR REPLACE EDITIONABLE SYNONYM "VRS"."JSON" FOR "VRS"."PLJSON";
--------------------------------------------------------
--  DDL for Synonymn JSON_AC
--------------------------------------------------------

  CREATE OR REPLACE EDITIONABLE SYNONYM "VRS"."JSON_AC" FOR "VRS"."PLJSON_AC";
--------------------------------------------------------
--  DDL for Synonymn JSON_DYN
--------------------------------------------------------

  CREATE OR REPLACE EDITIONABLE SYNONYM "VRS"."JSON_DYN" FOR "VRS"."PLJSON_DYN";
--------------------------------------------------------
--  DDL for Synonymn JSON_EXT
--------------------------------------------------------

  CREATE OR REPLACE EDITIONABLE SYNONYM "VRS"."JSON_EXT" FOR "VRS"."PLJSON_EXT";
--------------------------------------------------------
--  DDL for Synonymn JSON_HELPER
--------------------------------------------------------

  CREATE OR REPLACE EDITIONABLE SYNONYM "VRS"."JSON_HELPER" FOR "VRS"."PLJSON_HELPER";
--------------------------------------------------------
--  DDL for Synonymn JSON_LIST
--------------------------------------------------------

  CREATE OR REPLACE EDITIONABLE SYNONYM "VRS"."JSON_LIST" FOR "VRS"."PLJSON_LIST";
--------------------------------------------------------
--  DDL for Synonymn JSON_ML
--------------------------------------------------------

  CREATE OR REPLACE EDITIONABLE SYNONYM "VRS"."JSON_ML" FOR "VRS"."PLJSON_ML";
--------------------------------------------------------
--  DDL for Synonymn JSON_PARSER
--------------------------------------------------------

  CREATE OR REPLACE EDITIONABLE SYNONYM "VRS"."JSON_PARSER" FOR "VRS"."PLJSON_PARSER";
--------------------------------------------------------
--  DDL for Synonymn JSON_PRINTER
--------------------------------------------------------

  CREATE OR REPLACE EDITIONABLE SYNONYM "VRS"."JSON_PRINTER" FOR "VRS"."PLJSON_PRINTER";
--------------------------------------------------------
--  DDL for Synonymn JSON_TABLE
--------------------------------------------------------

  CREATE OR REPLACE EDITIONABLE SYNONYM "VRS"."JSON_TABLE" FOR "VRS"."PLJSON_TABLE";
--------------------------------------------------------
--  DDL for Synonymn JSON_UTIL_PKG
--------------------------------------------------------

  CREATE OR REPLACE EDITIONABLE SYNONYM "VRS"."JSON_UTIL_PKG" FOR "VRS"."PLJSON_UTIL_PKG";
--------------------------------------------------------
--  DDL for Synonymn JSON_VALUE
--------------------------------------------------------

  CREATE OR REPLACE EDITIONABLE SYNONYM "VRS"."JSON_VALUE" FOR "VRS"."PLJSON_VALUE";
--------------------------------------------------------
--  DDL for Synonymn JSON_VALUE_ARRAY
--------------------------------------------------------

  CREATE OR REPLACE EDITIONABLE SYNONYM "VRS"."JSON_VALUE_ARRAY" FOR "VRS"."PLJSON_VALUE_ARRAY";
--------------------------------------------------------
--  DDL for Synonymn JSON_XML
--------------------------------------------------------

  CREATE OR REPLACE EDITIONABLE SYNONYM "VRS"."JSON_XML" FOR "VRS"."PLJSON_XML";
--------------------------------------------------------
--  DDL for Synonymn PLJSON_TABLE
--------------------------------------------------------

  CREATE OR REPLACE EDITIONABLE SYNONYM "VRS"."PLJSON_TABLE" FOR "VRS"."PLJSON_TABLE_IMPL";
--------------------------------------------------------
--  Constraints for Table ESIGN
--------------------------------------------------------

  ALTER TABLE "VRS"."ESIGN" MODIFY ("ID" NOT NULL ENABLE);
  ALTER TABLE "VRS"."ESIGN" ADD CONSTRAINT "ESIGN_PK" PRIMARY KEY ("ID")
  USING INDEX (CREATE INDEX "VRS"."ESIGN_INDEX1" ON "VRS"."ESIGN" ("ID") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "USERS" )  ENABLE;
--------------------------------------------------------
--  Constraints for Table REG_VEHICLE_OWNER1SHIP
--------------------------------------------------------

  ALTER TABLE "VRS"."REG_VEHICLE_OWNER1SHIP" MODIFY ("ID" NOT NULL ENABLE);
  ALTER TABLE "VRS"."REG_VEHICLE_OWNER1SHIP" MODIFY ("VEHICLE_ID" NOT NULL DISABLE);
  ALTER TABLE "VRS"."REG_VEHICLE_OWNER1SHIP" MODIFY ("OWNER1_ID" NOT NULL DISABLE);
  ALTER TABLE "VRS"."REG_VEHICLE_OWNER1SHIP" ADD PRIMARY KEY ("ID")
  USING INDEX PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "USERS"  ENABLE;
--------------------------------------------------------
--  Constraints for Table OWNER
--------------------------------------------------------

  ALTER TABLE "VRS"."OWNER" MODIFY ("ID" NOT NULL ENABLE);
  ALTER TABLE "VRS"."OWNER" ADD CONSTRAINT "OWNER_PK" PRIMARY KEY ("ID")
  USING INDEX PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "USERS"  ENABLE;
--------------------------------------------------------
--  Constraints for Table SYSTEM_PLATE_FACTORY
--------------------------------------------------------

  ALTER TABLE "VRS"."SYSTEM_PLATE_FACTORY" MODIFY ("ID" NOT NULL ENABLE);
  ALTER TABLE "VRS"."SYSTEM_PLATE_FACTORY" ADD CONSTRAINT "SYSTEM_PLATE_FACTORY_PK" PRIMARY KEY ("ID")
  USING INDEX PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_INDEX"  ENABLE;
--------------------------------------------------------
--  Constraints for Table ADDRESS_SUBDEV_OLD
--------------------------------------------------------

  ALTER TABLE "VRS"."ADDRESS_SUBDEV_OLD" MODIFY ("ID" NOT NULL ENABLE);
  ALTER TABLE "VRS"."ADDRESS_SUBDEV_OLD" ADD PRIMARY KEY ("ID")
  USING INDEX PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_INDEX"  ENABLE;
--------------------------------------------------------
--  Constraints for Table REG_PLATENUMBER_SAVE
--------------------------------------------------------

  ALTER TABLE "VRS"."REG_PLATENUMBER_SAVE" MODIFY ("ID" NOT NULL ENABLE);
  ALTER TABLE "VRS"."REG_PLATENUMBER_SAVE" MODIFY ("ARCHIVE_NUMBER" NOT NULL ENABLE);
  ALTER TABLE "VRS"."REG_PLATENUMBER_SAVE" MODIFY ("PLATE_NO" NOT NULL ENABLE);
  ALTER TABLE "VRS"."REG_PLATENUMBER_SAVE" MODIFY ("BEGIN_DATE" NOT NULL ENABLE);
  ALTER TABLE "VRS"."REG_PLATENUMBER_SAVE" MODIFY ("END_DATE" NOT NULL ENABLE);
  ALTER TABLE "VRS"."REG_PLATENUMBER_SAVE" ADD PRIMARY KEY ("ID")
  USING INDEX PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "USERS"  ENABLE;
--------------------------------------------------------
--  Constraints for Table SYSTEM_PRINTER
--------------------------------------------------------

  ALTER TABLE "VRS"."SYSTEM_PRINTER" MODIFY ("ID" NOT NULL ENABLE);
  ALTER TABLE "VRS"."SYSTEM_PRINTER" ADD CONSTRAINT "SYSTEM_PRINTER_PK" PRIMARY KEY ("ID")
  USING INDEX PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_INDEX"  ENABLE;
--------------------------------------------------------
--  Constraints for Table EPAY_TRANSACTION
--------------------------------------------------------

  ALTER TABLE "VRS"."EPAY_TRANSACTION" MODIFY ("ID" NOT NULL ENABLE);
  ALTER TABLE "VRS"."EPAY_TRANSACTION" ADD CONSTRAINT "EPAY_TRANSACTION_PK" PRIMARY KEY ("ID")
  USING INDEX PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "USERS"  ENABLE;
--------------------------------------------------------
--  Constraints for Table LOG_UPDATED
--------------------------------------------------------

  ALTER TABLE "VRS"."LOG_UPDATED" MODIFY ("ID" NOT NULL ENABLE);
--------------------------------------------------------
--  Constraints for Table REF_ENGINE_MODEL
--------------------------------------------------------

  ALTER TABLE "VRS"."REF_ENGINE_MODEL" MODIFY ("ID" NOT NULL ENABLE);
  ALTER TABLE "VRS"."REF_ENGINE_MODEL" MODIFY ("IS_OTHER_MARK" NOT NULL ENABLE);
  ALTER TABLE "VRS"."REF_ENGINE_MODEL" ADD CONSTRAINT "REF_ENGINE_MODEL_PK" PRIMARY KEY ("ID")
  USING INDEX PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_INDEX"  ENABLE;
--------------------------------------------------------
--  Constraints for Table REG_MARK
--------------------------------------------------------

  ALTER TABLE "VRS"."REG_MARK" MODIFY ("ID" NOT NULL ENABLE);
  ALTER TABLE "VRS"."REG_MARK" MODIFY ("COUNTRY_ID" NOT NULL ENABLE);
  ALTER TABLE "VRS"."REG_MARK" ADD PRIMARY KEY ("ID")
  USING INDEX PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_INDEX"  ENABLE;
--------------------------------------------------------
--  Constraints for Table REG_REFERENCE_LOG
--------------------------------------------------------

  ALTER TABLE "VRS"."REG_REFERENCE_LOG" ADD CONSTRAINT "REG_REFERENCE_LOG_PK" PRIMARY KEY ("ID")
  USING INDEX PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_INDEX"  ENABLE;
--------------------------------------------------------
--  Constraints for Table ADDRESS_MICRODISTRICT
--------------------------------------------------------

  ALTER TABLE "VRS"."ADDRESS_MICRODISTRICT" MODIFY ("ID" NOT NULL ENABLE);
  ALTER TABLE "VRS"."ADDRESS_MICRODISTRICT" ADD CONSTRAINT "ADDRESS_MICRODISTRICT_PK" PRIMARY KEY ("ID")
  USING INDEX PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_INDEX"  ENABLE;
--------------------------------------------------------
--  Constraints for Table SYSTEM_DEPTYPE
--------------------------------------------------------

  ALTER TABLE "VRS"."SYSTEM_DEPTYPE" MODIFY ("ID" NOT NULL ENABLE);
  ALTER TABLE "VRS"."SYSTEM_DEPTYPE" ADD CONSTRAINT "SYSTEM_DEPTYPE_PK" PRIMARY KEY ("ID")
  USING INDEX PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_INDEX"  ENABLE;
--------------------------------------------------------
--  Constraints for Table SYSTEM_MENU
--------------------------------------------------------

  ALTER TABLE "VRS"."SYSTEM_MENU" MODIFY ("ID" NOT NULL ENABLE);
  ALTER TABLE "VRS"."SYSTEM_MENU" ADD PRIMARY KEY ("ID")
  USING INDEX PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_INDEX"  ENABLE;
--------------------------------------------------------
--  Constraints for Table OLD_VEHICLE_DATA
--------------------------------------------------------

  ALTER TABLE "VRS"."OLD_VEHICLE_DATA" MODIFY ("VEHICLE_ID" NOT NULL ENABLE);
--------------------------------------------------------
--  Constraints for Table REG_EXHAUST_NUMBER
--------------------------------------------------------

  ALTER TABLE "VRS"."REG_EXHAUST_NUMBER" MODIFY ("ID" NOT NULL ENABLE);
  ALTER TABLE "VRS"."REG_EXHAUST_NUMBER" MODIFY ("VEHICLE_ID" NOT NULL ENABLE);
  ALTER TABLE "VRS"."REG_EXHAUST_NUMBER" MODIFY ("EXHAUST_NUMBER" NOT NULL ENABLE);
  ALTER TABLE "VRS"."REG_EXHAUST_NUMBER" MODIFY ("CREATED_BY" NOT NULL ENABLE);
  ALTER TABLE "VRS"."REG_EXHAUST_NUMBER" MODIFY ("CREATED_DATE" NOT NULL ENABLE);
  ALTER TABLE "VRS"."REG_EXHAUST_NUMBER" ADD CONSTRAINT "REG_EXHAUST_NUMBER_PK" PRIMARY KEY ("ID")
  USING INDEX PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  TABLESPACE "USERS"  ENABLE;
--------------------------------------------------------
--  Constraints for Table REG_RFID_TAG_PHOTO
--------------------------------------------------------

  ALTER TABLE "VRS"."REG_RFID_TAG_PHOTO" MODIFY ("ID" NOT NULL ENABLE);
  ALTER TABLE "VRS"."REG_RFID_TAG_PHOTO" MODIFY ("RFID_TAG_ID" NOT NULL ENABLE);
  ALTER TABLE "VRS"."REG_RFID_TAG_PHOTO" ADD CONSTRAINT "REG_RFID_TAG_PHOTO_PK" PRIMARY KEY ("ID")
  USING INDEX PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  TABLESPACE "USERS"  ENABLE;
--------------------------------------------------------
--  Constraints for Table SERIES_REMOVAL
--------------------------------------------------------

  ALTER TABLE "VRS"."SERIES_REMOVAL" MODIFY ("ID" NOT NULL ENABLE);
  ALTER TABLE "VRS"."SERIES_REMOVAL" ADD PRIMARY KEY ("ID")
  USING INDEX PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_INDEX"  ENABLE;
--------------------------------------------------------
--  Constraints for Table ADDRESS_PROVINCE_OLD
--------------------------------------------------------

  ALTER TABLE "VRS"."ADDRESS_PROVINCE_OLD" MODIFY ("ID" NOT NULL ENABLE);
  ALTER TABLE "VRS"."ADDRESS_PROVINCE_OLD" ADD PRIMARY KEY ("ID")
  USING INDEX PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_INDEX"  ENABLE;
--------------------------------------------------------
--  Constraints for Table SERIES
--------------------------------------------------------

  ALTER TABLE "VRS"."SERIES" MODIFY ("ID" NOT NULL ENABLE);
  ALTER TABLE "VRS"."SERIES" MODIFY ("PROVINCE_ID" NOT NULL ENABLE);
  ALTER TABLE "VRS"."SERIES" ADD PRIMARY KEY ("ID")
  USING INDEX PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_INDEX"  ENABLE;
--------------------------------------------------------
--  Constraints for Table SYSTEM_DEPARTMENT
--------------------------------------------------------

  ALTER TABLE "VRS"."SYSTEM_DEPARTMENT" MODIFY ("ID" NOT NULL ENABLE);
  ALTER TABLE "VRS"."SYSTEM_DEPARTMENT" ADD PRIMARY KEY ("ID")
  USING INDEX PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_INDEX"  ENABLE;
--------------------------------------------------------
--  Constraints for Table TRANSACTION
--------------------------------------------------------

  ALTER TABLE "VRS"."TRANSACTION" MODIFY ("ID" NOT NULL ENABLE);
  ALTER TABLE "VRS"."TRANSACTION" ADD CONSTRAINT "TABLE1_PK" PRIMARY KEY ("ID")
  USING INDEX PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "USERS"  ENABLE;
--------------------------------------------------------
--  Constraints for Table ADDRESS_SUBDEV_UNIT
--------------------------------------------------------

  ALTER TABLE "VRS"."ADDRESS_SUBDEV_UNIT" MODIFY ("ID" NOT NULL ENABLE);
  ALTER TABLE "VRS"."ADDRESS_SUBDEV_UNIT" ADD PRIMARY KEY ("ID")
  USING INDEX PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_INDEX"  ENABLE;
--------------------------------------------------------
--  Constraints for Table REG_PLATENUMBER_SAVE_ORDER
--------------------------------------------------------

  ALTER TABLE "VRS"."REG_PLATENUMBER_SAVE_ORDER" MODIFY ("ID" NOT NULL ENABLE);
  ALTER TABLE "VRS"."REG_PLATENUMBER_SAVE_ORDER" ADD CONSTRAINT "REG_PLATENUMBER_SAVE_ORDER_PK" PRIMARY KEY ("ID")
  USING INDEX PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "USERS"  ENABLE;
--------------------------------------------------------
--  Constraints for Table TEMP_LIMIT
--------------------------------------------------------

  ALTER TABLE "VRS"."TEMP_LIMIT" MODIFY ("ID" NOT NULL ENABLE);
--------------------------------------------------------
--  Constraints for Table OWNER_TYPE
--------------------------------------------------------

  ALTER TABLE "VRS"."OWNER_TYPE" MODIFY ("ID" NOT NULL ENABLE);
  ALTER TABLE "VRS"."OWNER_TYPE" ADD PRIMARY KEY ("ID")
  USING INDEX PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_INDEX"  ENABLE;
--------------------------------------------------------
--  Constraints for Table REF_COUNTRY
--------------------------------------------------------

  ALTER TABLE "VRS"."REF_COUNTRY" MODIFY ("ID" NOT NULL ENABLE);
  ALTER TABLE "VRS"."REF_COUNTRY" ADD PRIMARY KEY ("ID")
  USING INDEX PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_INDEX"  ENABLE;
--------------------------------------------------------
--  Constraints for Table REG_LIMIT_TYPE
--------------------------------------------------------

  ALTER TABLE "VRS"."REG_LIMIT_TYPE" MODIFY ("ID" NOT NULL ENABLE);
  ALTER TABLE "VRS"."REG_LIMIT_TYPE" ADD PRIMARY KEY ("ID")
  USING INDEX PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_INDEX"  ENABLE;
--------------------------------------------------------
--  Constraints for Table REG_STATUS
--------------------------------------------------------

  ALTER TABLE "VRS"."REG_STATUS" MODIFY ("ID" NOT NULL ENABLE);
  ALTER TABLE "VRS"."REG_STATUS" ADD CONSTRAINT "REG_STATUS_PK" PRIMARY KEY ("ID")
  USING INDEX PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_INDEX"  ENABLE;
--------------------------------------------------------
--  Constraints for Table SYSTEM_ARCHIVE
--------------------------------------------------------

  ALTER TABLE "VRS"."SYSTEM_ARCHIVE" MODIFY ("ID" NOT NULL ENABLE);
  ALTER TABLE "VRS"."SYSTEM_ARCHIVE" MODIFY ("PROVINCEID" NOT NULL ENABLE);
  ALTER TABLE "VRS"."SYSTEM_ARCHIVE" MODIFY ("DEPARTMENTID" NOT NULL ENABLE);
  ALTER TABLE "VRS"."SYSTEM_ARCHIVE" MODIFY ("ARCHIVE" NOT NULL ENABLE);
  ALTER TABLE "VRS"."SYSTEM_ARCHIVE" MODIFY ("ABBR" NOT NULL ENABLE);
  ALTER TABLE "VRS"."SYSTEM_ARCHIVE" MODIFY ("CREATEDBY" NOT NULL ENABLE);
  ALTER TABLE "VRS"."SYSTEM_ARCHIVE" MODIFY ("MODIFIEDBY" NOT NULL ENABLE);
  ALTER TABLE "VRS"."SYSTEM_ARCHIVE" MODIFY ("CREATEDDATE" NOT NULL ENABLE);
  ALTER TABLE "VRS"."SYSTEM_ARCHIVE" MODIFY ("MODIFIEDDATE" NOT NULL ENABLE);
  ALTER TABLE "VRS"."SYSTEM_ARCHIVE" ADD CONSTRAINT "SYSTEM_ARCHIVE_PKID_PK" PRIMARY KEY ("ID")
  USING INDEX PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_INDEX"  ENABLE;
--------------------------------------------------------
--  Constraints for Table REG_CERTIFICATE
--------------------------------------------------------

  ALTER TABLE "VRS"."REG_CERTIFICATE" MODIFY ("ID" NOT NULL ENABLE);
  ALTER TABLE "VRS"."REG_CERTIFICATE" ADD CONSTRAINT "USER_GERCHILGEE_OLGOLT_PK" PRIMARY KEY ("ID")
  USING INDEX PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_INDEX"  ENABLE;
--------------------------------------------------------
--  Constraints for Table REG_LIMITED
--------------------------------------------------------

  ALTER TABLE "VRS"."REG_LIMITED" MODIFY ("ID" NOT NULL ENABLE);
  ALTER TABLE "VRS"."REG_LIMITED" ADD CONSTRAINT "REG_LIMITED_PK" PRIMARY KEY ("ID")
  USING INDEX PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_INDEX"  ENABLE;
--------------------------------------------------------
--  Constraints for Table REG_VEHICLE_INSP_ARCHIVE
--------------------------------------------------------

  ALTER TABLE "VRS"."REG_VEHICLE_INSP_ARCHIVE" MODIFY ("ID" NOT NULL ENABLE);
  ALTER TABLE "VRS"."REG_VEHICLE_INSP_ARCHIVE" MODIFY ("VEHICLE_ID" NOT NULL ENABLE);
  ALTER TABLE "VRS"."REG_VEHICLE_INSP_ARCHIVE" MODIFY ("CABIN_NO" NOT NULL ENABLE);
  ALTER TABLE "VRS"."REG_VEHICLE_INSP_ARCHIVE" ADD CONSTRAINT "REG_VEHICLE_INSP_ARCHIVE_PK" PRIMARY KEY ("ID")
  USING INDEX PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_INDEX"  ENABLE;
--------------------------------------------------------
--  Constraints for Table REF_COLOR
--------------------------------------------------------

  ALTER TABLE "VRS"."REF_COLOR" MODIFY ("ID" NOT NULL ENABLE);
  ALTER TABLE "VRS"."REF_COLOR" ADD CONSTRAINT "REF_COLOR_PK" PRIMARY KEY ("ID")
  USING INDEX PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_INDEX"  ENABLE;
--------------------------------------------------------
--  Constraints for Table REF_COLOR_TYPE
--------------------------------------------------------

  ALTER TABLE "VRS"."REF_COLOR_TYPE" MODIFY ("ID" NOT NULL ENABLE);
--------------------------------------------------------
--  Constraints for Table REG_TORGUULI
--------------------------------------------------------

  ALTER TABLE "VRS"."REG_TORGUULI" MODIFY ("ID" NOT NULL ENABLE);
  ALTER TABLE "VRS"."REG_TORGUULI" MODIFY ("CABIN_NO" NOT NULL ENABLE);
  ALTER TABLE "VRS"."REG_TORGUULI" MODIFY ("PLATE_NO" NOT NULL ENABLE);
  ALTER TABLE "VRS"."REG_TORGUULI" MODIFY ("Zorchil" NOT NULL ENABLE);
  ALTER TABLE "VRS"."REG_TORGUULI" MODIFY ("SUMMARY" NOT NULL ENABLE);
--------------------------------------------------------
--  Constraints for Table REG_VEHICLE
--------------------------------------------------------

  ALTER TABLE "VRS"."REG_VEHICLE" MODIFY ("ID" NOT NULL ENABLE);
  ALTER TABLE "VRS"."REG_VEHICLE" MODIFY ("CABIN_NO" NOT NULL ENABLE);
  ALTER TABLE "VRS"."REG_VEHICLE" ADD CONSTRAINT "REG_VEHICLE_PK" PRIMARY KEY ("ID")
  USING INDEX PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_INDEX"  ENABLE;
--------------------------------------------------------
--  Constraints for Table SERIES_NUMBER
--------------------------------------------------------

  ALTER TABLE "VRS"."SERIES_NUMBER" MODIFY ("ID" NOT NULL ENABLE);
  ALTER TABLE "VRS"."SERIES_NUMBER" MODIFY ("NAME" NOT NULL ENABLE);
  ALTER TABLE "VRS"."SERIES_NUMBER" MODIFY ("IS_GIVEN" NOT NULL ENABLE);
  ALTER TABLE "VRS"."SERIES_NUMBER" MODIFY ("IS_HIDDEN" NOT NULL ENABLE);
  ALTER TABLE "VRS"."SERIES_NUMBER" MODIFY ("IS_LOCAL" NOT NULL ENABLE);
  ALTER TABLE "VRS"."SERIES_NUMBER" MODIFY ("IS_OPENED" NOT NULL ENABLE);
  ALTER TABLE "VRS"."SERIES_NUMBER" MODIFY ("IS_ORDER" NOT NULL ENABLE);
  ALTER TABLE "VRS"."SERIES_NUMBER" MODIFY ("ISAUCTION" NOT NULL ENABLE);
  ALTER TABLE "VRS"."SERIES_NUMBER" MODIFY ("IS_SAVE" NOT NULL ENABLE);
  ALTER TABLE "VRS"."SERIES_NUMBER" ADD CONSTRAINT "SERIES_NUMBER_PK" PRIMARY KEY ("ID")
  USING INDEX PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_INDEX"  ENABLE;
--------------------------------------------------------
--  Constraints for Table ADDRESS_PROVINCE
--------------------------------------------------------

  ALTER TABLE "VRS"."ADDRESS_PROVINCE" MODIFY ("ID" NOT NULL ENABLE);
  ALTER TABLE "VRS"."ADDRESS_PROVINCE" ADD CONSTRAINT "ADDRESS_PROVINCE_NEW_PK" PRIMARY KEY ("ID")
  USING INDEX PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "USERS"  ENABLE;
--------------------------------------------------------
--  Constraints for Table ADDRESS_SUBDEV_UNIT_OLD
--------------------------------------------------------

  ALTER TABLE "VRS"."ADDRESS_SUBDEV_UNIT_OLD" MODIFY ("ID" NOT NULL ENABLE);
  ALTER TABLE "VRS"."ADDRESS_SUBDEV_UNIT_OLD" ADD PRIMARY KEY ("ID")
  USING INDEX PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_INDEX"  ENABLE;
--------------------------------------------------------
--  Constraints for Table ARCHIVE_NUMBER
--------------------------------------------------------

  ALTER TABLE "VRS"."ARCHIVE_NUMBER" MODIFY ("ID" NOT NULL ENABLE);
  ALTER TABLE "VRS"."ARCHIVE_NUMBER" MODIFY ("PLATE_SAVE_COUNT" NOT NULL ENABLE);
  ALTER TABLE "VRS"."ARCHIVE_NUMBER" ADD PRIMARY KEY ("ID")
  USING INDEX PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_INDEX"  ENABLE;
--------------------------------------------------------
--  Constraints for Table REF_PURPOSE
--------------------------------------------------------

  ALTER TABLE "VRS"."REF_PURPOSE" MODIFY ("ID" NOT NULL ENABLE);
  ALTER TABLE "VRS"."REF_PURPOSE" ADD CONSTRAINT "REF_PURPOSE_PK" PRIMARY KEY ("ID")
  USING INDEX PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_INDEX"  ENABLE;
--------------------------------------------------------
--  Constraints for Table REG_MODIPICACE
--------------------------------------------------------

  ALTER TABLE "VRS"."REG_MODIPICACE" MODIFY ("ID" NOT NULL ENABLE);
  ALTER TABLE "VRS"."REG_MODIPICACE" ADD CONSTRAINT "REG_MODIPICACE_PK" PRIMARY KEY ("ID")
  USING INDEX PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_INDEX"  ENABLE;
--------------------------------------------------------
--  Constraints for Table SYSTEM_DIVISIONUNIT
--------------------------------------------------------

  ALTER TABLE "VRS"."SYSTEM_DIVISIONUNIT" MODIFY ("ID" NOT NULL ENABLE);
  ALTER TABLE "VRS"."SYSTEM_DIVISIONUNIT" ADD PRIMARY KEY ("ID")
  USING INDEX PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_INDEX"  ENABLE;
--------------------------------------------------------
--  Constraints for Table SYSTEM_POSITION
--------------------------------------------------------

  ALTER TABLE "VRS"."SYSTEM_POSITION" MODIFY ("ID" NOT NULL ENABLE);
  ALTER TABLE "VRS"."SYSTEM_POSITION" MODIFY ("NAME" NOT NULL ENABLE);
  ALTER TABLE "VRS"."SYSTEM_POSITION" MODIFY ("CREATEDBY" NOT NULL ENABLE);
  ALTER TABLE "VRS"."SYSTEM_POSITION" MODIFY ("MODIFIEDBY" NOT NULL ENABLE);
  ALTER TABLE "VRS"."SYSTEM_POSITION" MODIFY ("CREATEDDATE" NOT NULL ENABLE);
  ALTER TABLE "VRS"."SYSTEM_POSITION" MODIFY ("MODIFIEDDATE" NOT NULL ENABLE);
  ALTER TABLE "VRS"."SYSTEM_POSITION" ADD CONSTRAINT "MAIN_USER_POSITION_ID_PK" PRIMARY KEY ("ID")
  USING INDEX PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_INDEX"  ENABLE;
--------------------------------------------------------
--  Constraints for Table SYSTEM_USER_MENU
--------------------------------------------------------

  ALTER TABLE "VRS"."SYSTEM_USER_MENU" MODIFY ("ID" NOT NULL DISABLE);
  ALTER TABLE "VRS"."SYSTEM_USER_MENU" ADD PRIMARY KEY ("ID") DISABLE;
--------------------------------------------------------
--  Constraints for Table REG_MODEL
--------------------------------------------------------

  ALTER TABLE "VRS"."REG_MODEL" MODIFY ("ID" NOT NULL ENABLE);
  ALTER TABLE "VRS"."REG_MODEL" MODIFY ("MARK_ID" NOT NULL ENABLE);
  ALTER TABLE "VRS"."REG_MODEL" ADD CONSTRAINT "REG_MODEL_PK1" PRIMARY KEY ("ID")
  USING INDEX PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_INDEX"  ENABLE;
--------------------------------------------------------
--  Constraints for Table SYSTEM_SERVICE
--------------------------------------------------------

  ALTER TABLE "VRS"."SYSTEM_SERVICE" MODIFY ("ID" NOT NULL ENABLE);
  ALTER TABLE "VRS"."SYSTEM_SERVICE" ADD PRIMARY KEY ("ID")
  USING INDEX PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_INDEX"  ENABLE;
--------------------------------------------------------
--  Constraints for Table REG_VEHICLE_TYPE
--------------------------------------------------------

  ALTER TABLE "VRS"."REG_VEHICLE_TYPE" MODIFY ("ID" NOT NULL ENABLE);
  ALTER TABLE "VRS"."REG_VEHICLE_TYPE" MODIFY ("PURPOSE_ID" NOT NULL ENABLE);
  ALTER TABLE "VRS"."REG_VEHICLE_TYPE" ADD PRIMARY KEY ("ID")
  USING INDEX PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_INDEX"  ENABLE;
--------------------------------------------------------
--  Constraints for Table SERIES_INTERVAL
--------------------------------------------------------

  ALTER TABLE "VRS"."SERIES_INTERVAL" MODIFY ("ID" NOT NULL ENABLE);
  ALTER TABLE "VRS"."SERIES_INTERVAL" ADD CONSTRAINT "SERIES_INTERVAL_PK" PRIMARY KEY ("ID")
  USING INDEX PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_INDEX"  ENABLE;
--------------------------------------------------------
--  Constraints for Table SYSTEM_USER
--------------------------------------------------------

  ALTER TABLE "VRS"."SYSTEM_USER" MODIFY ("ID" NOT NULL ENABLE);
  ALTER TABLE "VRS"."SYSTEM_USER" MODIFY ("ISACTIVE" NOT NULL ENABLE);
  ALTER TABLE "VRS"."SYSTEM_USER" ADD PRIMARY KEY ("ID")
  USING INDEX PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_INDEX"  ENABLE;
--------------------------------------------------------
--  Constraints for Table ADDRESS_SUBDEV
--------------------------------------------------------

  ALTER TABLE "VRS"."ADDRESS_SUBDEV" MODIFY ("ID" NOT NULL ENABLE);
  ALTER TABLE "VRS"."ADDRESS_SUBDEV" ADD PRIMARY KEY ("ID")
  USING INDEX PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_INDEX"  ENABLE;
--------------------------------------------------------
--  Constraints for Table OWNER_OLD
--------------------------------------------------------

  ALTER TABLE "VRS"."OWNER_OLD" MODIFY ("ID" NOT NULL DISABLE);
--------------------------------------------------------
--  Constraints for Table REF_GENERAL
--------------------------------------------------------

  ALTER TABLE "VRS"."REF_GENERAL" MODIFY ("ID" NOT NULL ENABLE);
  ALTER TABLE "VRS"."REF_GENERAL" MODIFY ("REF_TYPE" NOT NULL ENABLE);
  ALTER TABLE "VRS"."REF_GENERAL" ADD PRIMARY KEY ("ID")
  USING INDEX PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_INDEX"  ENABLE;
--------------------------------------------------------
--  Constraints for Table REF_GENERAL_TYPE
--------------------------------------------------------

  ALTER TABLE "VRS"."REF_GENERAL_TYPE" MODIFY ("ID" NOT NULL ENABLE);
  ALTER TABLE "VRS"."REF_GENERAL_TYPE" ADD PRIMARY KEY ("ID")
  USING INDEX PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_INDEX"  ENABLE;
--------------------------------------------------------
--  Constraints for Table REF_REFERENCE_ORG
--------------------------------------------------------

  ALTER TABLE "VRS"."REF_REFERENCE_ORG" MODIFY ("ID" NOT NULL ENABLE);
  ALTER TABLE "VRS"."REF_REFERENCE_ORG" ADD CONSTRAINT "REF_REFERENCE_ORG_PK" PRIMARY KEY ("ID")
  USING INDEX PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_INDEX"  ENABLE;
--------------------------------------------------------
--  Constraints for Table REG_RFID_TAG
--------------------------------------------------------

  ALTER TABLE "VRS"."REG_RFID_TAG" MODIFY ("ID" NOT NULL ENABLE);
  ALTER TABLE "VRS"."REG_RFID_TAG" MODIFY ("IS_INCONSISTENT" NOT NULL ENABLE);
  ALTER TABLE "VRS"."REG_RFID_TAG" MODIFY ("STATUS" NOT NULL ENABLE);
  ALTER TABLE "VRS"."REG_RFID_TAG" ADD CONSTRAINT "REG_RFID_TAG_PK" PRIMARY KEY ("ID")
  USING INDEX (CREATE UNIQUE INDEX "VRS"."REG_RFID_TAG_IDX" ON "VRS"."REG_RFID_TAG" ("ID") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_INDEX" )  ENABLE;
--------------------------------------------------------
--  Constraints for Table REG_VEHICLE_OWNERSHIP
--------------------------------------------------------

  ALTER TABLE "VRS"."REG_VEHICLE_OWNERSHIP" MODIFY ("ID" NOT NULL DISABLE);
  ALTER TABLE "VRS"."REG_VEHICLE_OWNERSHIP" MODIFY ("VEHICLE_ID" NOT NULL DISABLE);
  ALTER TABLE "VRS"."REG_VEHICLE_OWNERSHIP" MODIFY ("OWNER_ID" NOT NULL DISABLE);
  ALTER TABLE "VRS"."REG_VEHICLE_OWNERSHIP" ADD PRIMARY KEY ("ID") DISABLE;
--------------------------------------------------------
--  Constraints for Table OWNER_STATUS
--------------------------------------------------------

  ALTER TABLE "VRS"."OWNER_STATUS" MODIFY ("ID" NOT NULL ENABLE);
  ALTER TABLE "VRS"."OWNER_STATUS" ADD CONSTRAINT "OWNER_STATUS_PK" PRIMARY KEY ("ID")
  USING INDEX PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "USERS"  ENABLE;
--------------------------------------------------------
--  Constraints for Table REG_VEHICLE_ARCHIVE
--------------------------------------------------------

  ALTER TABLE "VRS"."REG_VEHICLE_ARCHIVE" MODIFY ("ID" NOT NULL ENABLE);
  ALTER TABLE "VRS"."REG_VEHICLE_ARCHIVE" ADD CONSTRAINT "REG_VEHICLE_ARCHIVE_PK" PRIMARY KEY ("ID") DISABLE;
--------------------------------------------------------
--  Constraints for Table SYSTEM_ISSUE
--------------------------------------------------------

  ALTER TABLE "VRS"."SYSTEM_ISSUE" MODIFY ("ID" NOT NULL ENABLE);
--------------------------------------------------------
--  Constraints for Table SYSTEM_POSITION_LOG
--------------------------------------------------------

  ALTER TABLE "VRS"."SYSTEM_POSITION_LOG" MODIFY ("ID" NOT NULL ENABLE);
  ALTER TABLE "VRS"."SYSTEM_POSITION_LOG" ADD CONSTRAINT "SYSTEM_POSITION_LOG_PK" PRIMARY KEY ("ID")
  USING INDEX PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1
  BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "VRS_INDEX"  ENABLE;
--------------------------------------------------------
--  Ref Constraints for Table ADDRESS_PROVINCE_OLD
--------------------------------------------------------

  ALTER TABLE "VRS"."ADDRESS_PROVINCE_OLD" ADD CONSTRAINT "FKCEJ368W2EUA6F68U1AKQAOJBH" FOREIGN KEY ("CREATED_BY_ID")
	  REFERENCES "VRS"."SYSTEM_USER" ("ID") DISABLE;
  ALTER TABLE "VRS"."ADDRESS_PROVINCE_OLD" ADD CONSTRAINT "FKEDODBPOD1RW37N9NCEEEAGISC" FOREIGN KEY ("UPDATED_BY_ID")
	  REFERENCES "VRS"."SYSTEM_USER" ("ID") DISABLE;
--------------------------------------------------------
--  Ref Constraints for Table ADDRESS_SUBDEV_OLD
--------------------------------------------------------

  ALTER TABLE "VRS"."ADDRESS_SUBDEV_OLD" ADD CONSTRAINT "FKOCT1JYXQFWNL49UFCDLE2KTMM" FOREIGN KEY ("PROVINCE_ID")
	  REFERENCES "VRS"."ADDRESS_PROVINCE_OLD" ("ID") ENABLE;
  ALTER TABLE "VRS"."ADDRESS_SUBDEV_OLD" ADD CONSTRAINT "FK30PFGDPC433E7HIMY1O1JINOF" FOREIGN KEY ("UPDATED_BY_ID")
	  REFERENCES "VRS"."SYSTEM_USER" ("ID") ENABLE;
  ALTER TABLE "VRS"."ADDRESS_SUBDEV_OLD" ADD CONSTRAINT "FK2BKRUPRP80U5T553313C1RN34" FOREIGN KEY ("CREATED_BY_ID")
	  REFERENCES "VRS"."SYSTEM_USER" ("ID") ENABLE;
--------------------------------------------------------
--  Ref Constraints for Table ADDRESS_SUBDEV_UNIT_OLD
--------------------------------------------------------

  ALTER TABLE "VRS"."ADDRESS_SUBDEV_UNIT_OLD" ADD CONSTRAINT "FKQY0W7J11EPF0RN7RT23OHFIAY" FOREIGN KEY ("CREATED_BY_ID")
	  REFERENCES "VRS"."SYSTEM_USER" ("ID") DISABLE;
  ALTER TABLE "VRS"."ADDRESS_SUBDEV_UNIT_OLD" ADD CONSTRAINT "FKNCU1BQICOHX7013QYR40PMDJF" FOREIGN KEY ("UPDATED_BY_ID")
	  REFERENCES "VRS"."SYSTEM_USER" ("ID") DISABLE;
  ALTER TABLE "VRS"."ADDRESS_SUBDEV_UNIT_OLD" ADD CONSTRAINT "FKBM4PIFJ0NOTY1LHA55LR7VAJX" FOREIGN KEY ("DEVISION_ID")
	  REFERENCES "VRS"."ADDRESS_SUBDEV_OLD" ("ID") DISABLE;
--------------------------------------------------------
--  Ref Constraints for Table OWNER_TYPE
--------------------------------------------------------

  ALTER TABLE "VRS"."OWNER_TYPE" ADD CONSTRAINT "FKQVNUGU8SLTT9LRQ77PJGSA5OV" FOREIGN KEY ("CREATEDBY")
	  REFERENCES "VRS"."SYSTEM_USER" ("ID") ENABLE;
  ALTER TABLE "VRS"."OWNER_TYPE" ADD CONSTRAINT "FKSD1IAT7VQI753Y7VUVQ90153I" FOREIGN KEY ("UPDATEDBY")
	  REFERENCES "VRS"."SYSTEM_USER" ("ID") ENABLE;
--------------------------------------------------------
--  Ref Constraints for Table REF_GENERAL
--------------------------------------------------------

  ALTER TABLE "VRS"."REF_GENERAL" ADD CONSTRAINT "FKREF_GENERA388781" FOREIGN KEY ("REF_TYPE")
	  REFERENCES "VRS"."REF_GENERAL_TYPE" ("ID") ENABLE;
--------------------------------------------------------
--  Ref Constraints for Table REG_LIMIT_TYPE
--------------------------------------------------------

  ALTER TABLE "VRS"."REG_LIMIT_TYPE" ADD CONSTRAINT "FKJBS2M18F63VP8QA05PQQS1H3T" FOREIGN KEY ("UPDATED_BY_ID")
	  REFERENCES "VRS"."SYSTEM_USER" ("ID") ENABLE;
  ALTER TABLE "VRS"."REG_LIMIT_TYPE" ADD CONSTRAINT "FKOU31EK4646ORIC9TS1VR42GY9" FOREIGN KEY ("CREATED_BY_ID")
	  REFERENCES "VRS"."SYSTEM_USER" ("ID") ENABLE;
--------------------------------------------------------
--  Ref Constraints for Table REG_MARK
--------------------------------------------------------

  ALTER TABLE "VRS"."REG_MARK" ADD CONSTRAINT "FKREG_MARK148568" FOREIGN KEY ("COUNTRY_ID")
	  REFERENCES "VRS"."REF_COUNTRY" ("ID") DISABLE;
--------------------------------------------------------
--  Ref Constraints for Table REG_VEHICLE_OWNERSHIP
--------------------------------------------------------

  ALTER TABLE "VRS"."REG_VEHICLE_OWNERSHIP" ADD CONSTRAINT "FKREG_VEHICL610449" FOREIGN KEY ("OWNERSHIP_TYPE_ID")
	  REFERENCES "VRS"."REF_GENERAL" ("ID") DISABLE;
--------------------------------------------------------
--  Ref Constraints for Table SERIES_REMOVAL
--------------------------------------------------------

  ALTER TABLE "VRS"."SERIES_REMOVAL" ADD CONSTRAINT "FK6VGYI0U20H6352QY63G6R70ME" FOREIGN KEY ("UPDATED_BY_ID")
	  REFERENCES "VRS"."SYSTEM_USER" ("ID") ENABLE;
  ALTER TABLE "VRS"."SERIES_REMOVAL" ADD CONSTRAINT "FK3NO7MPMOKKOMV93BA4GDJX3Q7" FOREIGN KEY ("CREATED_BY_ID")
	  REFERENCES "VRS"."SYSTEM_USER" ("ID") ENABLE;
--------------------------------------------------------
--  Ref Constraints for Table SYSTEM_DIVISIONUNIT
--------------------------------------------------------

  ALTER TABLE "VRS"."SYSTEM_DIVISIONUNIT" ADD CONSTRAINT "FKH24UWK6NW2A0MX7WNRWUJMG31" FOREIGN KEY ("DIVISION_ID")
	  REFERENCES "VRS"."ADDRESS_PROVINCE_OLD" ("ID") DISABLE;
  ALTER TABLE "VRS"."SYSTEM_DIVISIONUNIT" ADD CONSTRAINT "FKSEP8PJ3GLII8UEB61U1IO6C7C" FOREIGN KEY ("UPDATED_BY_ID")
	  REFERENCES "VRS"."SYSTEM_USER" ("ID") DISABLE;
  ALTER TABLE "VRS"."SYSTEM_DIVISIONUNIT" ADD CONSTRAINT "FKRAT3KE73SOOKG15170EYT9DK7" FOREIGN KEY ("CREATED_BY_ID")
	  REFERENCES "VRS"."SYSTEM_USER" ("ID") DISABLE;
