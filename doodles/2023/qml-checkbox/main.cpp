#include <QGuiApplication>
#include <QQmlApplicationEngine>
#include <QQmlContext>

#include "TestClass.h"

int main(int argc, char *argv[])
{
    QGuiApplication       app(argc, argv);
    QQmlApplicationEngine engine;
    
    const QUrl url(u"qrc:/qml-checkbox/main.qml"_qs);
    
    QObject::connect(&engine, &QQmlApplicationEngine::objectCreated,
        &app, [url](QObject *obj, const QUrl &objUrl) {
        if (!obj && url == objUrl)
            QCoreApplication::exit(-1);
    }, Qt::QueuedConnection);
    
    TestClass test;
    
    engine.rootContext()->setContextProperty("__test", &test);
    engine.load(url);
    
    return app.exec();
}
