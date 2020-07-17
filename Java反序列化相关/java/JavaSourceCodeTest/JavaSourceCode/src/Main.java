public class Main {
    /**
     *
     * @param args default
     * this class will show what is
     */
    public static void main(String[] args) {

        //序列化
        Person person = new Person();
        person.setName("百无禁忌");
        SerializationUtil.writeObject(person);

        Person p = (Person) SerializationUtil.readObject();
        System.out.println("name = " + p.getName());
    }

}