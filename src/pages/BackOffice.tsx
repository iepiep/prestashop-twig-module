
import { useState } from "react";
import { toast } from "sonner";
import { Settings, ShoppingBag, BarChart3 } from "lucide-react";

import ModuleLayout from "@/components/prestashop/ModuleLayout";
import Header from "@/components/prestashop/Header";
import Card from "@/components/prestashop/Card";
import Form from "@/components/prestashop/Form";
import FieldGroup from "@/components/prestashop/FieldGroup";
import { Input } from "@/components/ui/input";
import { Switch } from "@/components/ui/switch";
import { Tabs, TabsContent, TabsList, TabsTrigger } from "@/components/ui/tabs";
import { Textarea } from "@/components/ui/textarea";

const BackOffice = () => {
  const [loading, setLoading] = useState(false);
  const [settings, setSettings] = useState({
    moduleName: "PrestaShop Module",
    displayOnHomepage: true,
    displayOnProductPage: true,
    customCSS: "",
    welcomeMessage: "Welcome to our store!",
  });

  const handleSettingsChange = (key: string, value: any) => {
    setSettings((prev) => ({ ...prev, [key]: value }));
  };

  const handleSubmit = (e: React.FormEvent) => {
    setLoading(true);
    
    // Simulate API call
    setTimeout(() => {
      setLoading(false);
      toast.success("Settings saved successfully");
      console.log("Saved settings:", settings);
    }, 800);
  };

  return (
    <ModuleLayout type="bo">
      <Header
        type="bo"
        title="Module Configuration"
        subtitle="Configure your PrestaShop module settings and customize the front office display."
      />

      <Tabs defaultValue="settings" className="space-y-6">
        <TabsList className="glass w-full justify-start p-1">
          <TabsTrigger value="settings" className="flex items-center gap-2">
            <Settings size={16} />
            <span>Settings</span>
          </TabsTrigger>
          <TabsTrigger value="display" className="flex items-center gap-2">
            <ShoppingBag size={16} />
            <span>Display</span>
          </TabsTrigger>
          <TabsTrigger value="stats" className="flex items-center gap-2">
            <BarChart3 size={16} />
            <span>Statistics</span>
          </TabsTrigger>
        </TabsList>

        <TabsContent value="settings" className="space-y-6 animate-fade-in">
          <Card title="General Settings">
            <Form onSubmit={handleSubmit} loading={loading}>
              <FieldGroup
                label="Module Name"
                htmlFor="moduleName"
                description="Display name of your module in the back office"
              >
                <Input
                  id="moduleName"
                  value={settings.moduleName}
                  onChange={(e) => handleSettingsChange("moduleName", e.target.value)}
                />
              </FieldGroup>

              <FieldGroup
                label="Welcome Message"
                htmlFor="welcomeMessage"
                description="Message displayed to customers in the front office"
              >
                <Textarea
                  id="welcomeMessage"
                  value={settings.welcomeMessage}
                  onChange={(e) => handleSettingsChange("welcomeMessage", e.target.value)}
                  rows={3}
                />
              </FieldGroup>
            </Form>
          </Card>
        </TabsContent>

        <TabsContent value="display" className="space-y-6 animate-fade-in">
          <Card title="Display Settings">
            <Form onSubmit={handleSubmit} loading={loading}>
              <FieldGroup
                label="Display on Homepage"
                description="Show module content on the store homepage"
              >
                <Switch
                  checked={settings.displayOnHomepage}
                  onCheckedChange={(value) => handleSettingsChange("displayOnHomepage", value)}
                />
              </FieldGroup>

              <FieldGroup
                label="Display on Product Page"
                description="Show module content on product pages"
              >
                <Switch
                  checked={settings.displayOnProductPage}
                  onCheckedChange={(value) => handleSettingsChange("displayOnProductPage", value)}
                />
              </FieldGroup>

              <FieldGroup
                label="Custom CSS"
                htmlFor="customCSS"
                description="Additional CSS for your module (optional)"
              >
                <Textarea
                  id="customCSS"
                  value={settings.customCSS}
                  onChange={(e) => handleSettingsChange("customCSS", e.target.value)}
                  rows={5}
                  placeholder=".my-custom-class { color: blue; }"
                  className="font-mono text-sm"
                />
              </FieldGroup>
            </Form>
          </Card>
        </TabsContent>

        <TabsContent value="stats" className="space-y-6 animate-fade-in">
          <Card title="Module Statistics">
            <div className="py-12 text-center text-muted-foreground">
              <BarChart3 className="mx-auto mb-4 h-12 w-12 opacity-20" />
              <p>Statistics feature is coming soon</p>
            </div>
          </Card>
        </TabsContent>
      </Tabs>
    </ModuleLayout>
  );
};

export default BackOffice;
